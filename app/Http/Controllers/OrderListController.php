<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderListController extends Controller
{
    /**
     * Dashboard Kasir - Tampilkan semua pesanan
     */
    public function kasirDashboard()
    {
        // Pastikan user adalah kasir, admin, atau pemilik
        if (! auth()->check() || (auth()->user()->role !== 'kasir' && auth()->user()->role !== 'admin' && auth()->user()->role !== 'pemilik')) {
            return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        // Ambil pesanan dengan status pending atau diproses
        $orders = Order::with(['orderItems.menu', 'pembayaran'])
            ->whereIn('status_order', ['pending', 'lunas', 'diproses'])
            ->latest('created_at')
            ->paginate(15);

        return view('order.kasir-dashboard', compact('orders'));
    }

    /**
     * Form Pesan Manual untuk Kasir / Admin
     */
    public function createManual()
    {
        if (! auth()->check() || ! in_array(auth()->user()->role, ['kasir', 'admin', 'pemilik'])) {
            return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }

        $menus = Menu::with('kategori')
            ->where('is_available', true)
            ->orderBy('nama_menu')
            ->get();

        $rawMenus = $menus->map(function ($m) {
            $fotoUrl = null;
            if ($m->foto) {
                if (file_exists(public_path('storage/' . $m->foto))) {
                    $fotoUrl = asset('storage/' . $m->foto);
                } elseif (file_exists(public_path('uploads/' . $m->foto))) {
                    $fotoUrl = asset('uploads/' . $m->foto);
                } elseif (str_starts_with($m->foto, 'http://') || str_starts_with($m->foto, 'https://')) {
                    $fotoUrl = $m->foto;
                } else {
                    $fotoUrl = asset('storage/' . $m->foto);
                }
            } else {
                $fotoUrl = 'https://placehold.co/400x300/1e293b/475569?text=' . urlencode($m->nama_menu);
            }

            return [
                'id_menu' => $m->id_menu,
                'nama_menu' => $m->nama_menu,
                'harga' => (int) $m->harga,
                'stok' => (int) $m->stok,
                'foto_url' => $fotoUrl,
                'kategori_nama' => $m->kategori->nama_kategori ?? 'Umum',
            ];
        });

        $kategoris = Kategori::all();

        return view('order.create-manual', compact('menus', 'kategoris', 'rawMenus'));
    }

    /**
     * Simpan Pesanan Manual dari Kasir
     */
    public function storeManual(Request $request)
    {
        if (! auth()->check() || ! in_array(auth()->user()->role, ['kasir', 'admin', 'pemilik'])) {
            return redirect('/dashboard')->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:100',
            'tipe_pesanan' => 'required|in:Dine In,Take Away',
            'no_meja' => 'nullable|string|max:10',
            'status_pembayaran' => 'required|in:lunas,pending',
            'uang_diterima' => 'nullable|numeric|min:0',
            'cetak_struk' => 'nullable',
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id_menu',
            'items.*.jumlah' => 'required|integer|min:1',
            'items.*.catatan' => 'nullable|string|max:255',
        ], [
            'items.required' => 'Pilih minimal satu menu untuk membuat pesanan.',
            'items.min' => 'Pilih minimal satu menu untuk membuat pesanan.',
            'nama_pelanggan.required' => 'Nama pelanggan wajib diisi.',
        ]);

        return DB::transaction(function () use ($validated, $request) {
            // Hitung total dari data database untuk keamanan harga
            $menuIds = collect($validated['items'])->pluck('menu_id');
            $dbMenus = Menu::whereIn('id_menu', $menuIds)->get()->keyBy('id_menu');

            $totalBayar = 0;
            foreach ($validated['items'] as $item) {
                $m = $dbMenus->get($item['menu_id']);
                if ($m) {
                    $totalBayar += $m->harga * $item['jumlah'];
                }
            }

            // Generate nomor order unik
            $noOrder = 'ORD-' . date('YmdHis') . '-' . rand(100, 999);

            $order = Order::create([
                'no_order' => $noOrder,
                'nama_pelanggan' => $validated['nama_pelanggan'],
                'total_bayar' => $totalBayar,
                'tipe_pesanan' => $validated['tipe_pesanan'],
                'no_meja' => $validated['tipe_pesanan'] === 'Dine In' ? ($validated['no_meja'] ?? null) : null,
                'status_order' => $validated['status_pembayaran'] === 'lunas' ? 'lunas' : 'pending',
                'user_id_kasir' => auth()->id(),
            ]);

            // Buat order items
            foreach ($validated['items'] as $item) {
                $m = $dbMenus->get($item['menu_id']);
                if ($m) {
                    OrderItem::create([
                        'order_id' => $order->id_order,
                        'menu_id' => $m->id_menu,
                        'jumlah' => $item['jumlah'],
                        'harga_satuan' => $m->harga,
                        'subtotal' => $m->harga * $item['jumlah'],
                        'catatan_khusus' => $item['catatan'] ?? null,
                    ]);
                }
            }

            // Catat pembayaran tunai
            $isLunas = $validated['status_pembayaran'] === 'lunas';
            Pembayaran::create([
                'order_id' => $order->id_order,
                'metode_bayar' => 'tunai',
                'status_bayar' => $isLunas ? 'lunas' : 'menunggu_kasir',
                'waktu_bayar' => $isLunas ? now() : null,
            ]);

            if ($request->filled('cetak_struk') && $request->cetak_struk == '1') {
                return redirect()->route('order.print', $order->id_order)
                    ->with('success', "Pesanan manual #{$order->no_order} berhasil dibuat!");
            }

            return redirect()->route('kasir.pesanan')
                ->with('success', "Pesanan manual #{$order->no_order} berhasil dibuat!");
        });
    }

    /**
     * Ubah status pesanan
     */
    public function updateStatus(Request $request, Order $order)
    {
        // Validasi user authorization - Allow kasir, admin, dan pemilik
        if (! auth()->check() || (auth()->user()->role !== 'kasir' && auth()->user()->role !== 'admin' && auth()->user()->role !== 'pemilik')) {
            return back()->with('error', 'Unauthorized');
        }

        $validated = $request->validate([
            'status_order' => 'required|in:pending,lunas,diproses,selesai',
        ]);

        $order->update([
            'status_order' => $validated['status_order'],
            'user_id_kasir' => auth()->id(),  // Catat kasir yang handle
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    /**
     * Lihat detail pesanan
     */
    public function show(Order $order)
    {
        $order->load(['orderItems.menu', 'pembayaran']);

        return view('order.detail', compact('order'));
    }

    /**
     * Cetak struk pesanan
     */
    public function print(Order $order)
    {
        $order->load(['orderItems.menu', 'pembayaran']);

        return view('order.print', compact('order'));
    }
}
