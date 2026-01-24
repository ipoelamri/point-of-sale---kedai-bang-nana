<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Kategori;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Halaman publik untuk menampilkan semua menu (Self-Service)
     */
    public function indexPublic(Request $request)
    {
        $kategori = $request->input('kategori', null);
        
        $query = Menu::with('kategori')->where('is_available', true);
        
        if ($kategori) {
            $query->whereHas('kategori', function ($q) use ($kategori) {
                $q->where('nama_kategori', $kategori);
            });
        }
        
        $menus = $query->paginate(12);
        $cart = session('cart', []);
        
        // Get all categories for filter buttons
        $kategoris = \App\Models\Kategori::all();
        
        return view('order.menu-public', compact('menus', 'cart', 'kategoris', 'kategori'));
    }

    /**
     * Tambah menu ke cart (session-based)
     */
    public function addToCart(Request $request, Menu $menu)
    {
        $cart = session('cart', []);
        $quantity = (int) $request->input('quantity', 1);

        if (isset($cart[$menu->id_menu])) {
            $cart[$menu->id_menu]['quantity'] += $quantity;
        } else {
            $cart[$menu->id_menu] = [
                'id_menu' => $menu->id_menu,
                'nama_menu' => $menu->nama_menu,
                'harga' => $menu->harga,
                'foto' => $menu->foto,
                'quantity' => $quantity,
            ];
        }

        session(['cart' => $cart]);

        return back()->with('success', "{$menu->nama_menu} ditambahkan ke keranjang!");
    }

    /**
     * Hapus item dari cart
     */
    public function removeFromCart($menuId)
    {
        $cart = session('cart', []);
        unset($cart[$menuId]);
        session(['cart' => $cart]);

        return back()->with('success', 'Item dihapus dari keranjang');
    }

    /**
     * Lihat isi cart
     */
    public function viewCart()
    {
        $cart = session('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['harga'] * $item['quantity'];
        }
        return view('order.cart', compact('cart', 'total'));
    }

    /**
     * Halaman checkout (form isi nama pelanggan, tipe pesanan)
     */
    public function showCheckout()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect('/menu')->with('error', 'Keranjang kosong!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['harga'] * $item['quantity'];
        }

        return view('order.checkout', compact('cart', 'total'));
    }

    /**
     * Proses checkout: buat order dan order_items
     */
    public function processCheckout(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:100',
            'tipe_pesanan' => 'required|in:dine-in,take-away',
            'no_meja' => 'nullable|string|max:10',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect('/menu')->with('error', 'Keranjang kosong!');
        }

        // Hitung total
        $totalBayar = 0;
        foreach ($cart as $item) {
            $totalBayar += $item['harga'] * $item['quantity'];
        }

        // Generate nomor order unik
        $noOrder = 'ORD-' . date('YmdHis') . '-' . rand(100, 999);

        // Buat order
        $order = Order::create([
            'no_order' => $noOrder,
            'nama_pelanggan' => $validated['nama_pelanggan'],
            'total_bayar' => $totalBayar,
            'tipe_pesanan' => $validated['tipe_pesanan'],
            'no_meja' => $validated['no_meja'] ?? null,
            'status_order' => 'pending',
            'user_id_kasir' => null,  // Self-service
        ]);

        // Buat order items
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id_order,
                'menu_id' => $item['id_menu'],
                'jumlah' => $item['quantity'],
                'harga_satuan' => $item['harga'],
                'subtotal' => $item['harga'] * $item['quantity'],
                'catatan_khusus' => null,
            ]);
        }

        // Simpan order ke session untuk digunakan di payment
        session(['current_order_id' => $order->id_order]);

        // Redirect ke halaman pembayaran
        return redirect()->route('order.payment', $order->id_order);
    }

    /**
     * Halaman pembayaran (show payment options)
     */
    public function showPayment(Order $order)
    {
        $orderItems = OrderItem::where('order_id', $order->id_order)->with('menu')->get();
        return view('order.payment', compact('order', 'orderItems'));
    }
}
