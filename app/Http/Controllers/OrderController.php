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
     * Update quantity item di cart
     */
    public function updateCart(Request $request, $menuId)
    {
        $cart = session('cart', []);
        $quantity = (int) $request->input('quantity', 1);

        if (isset($cart[$menuId])) {
            if ($quantity <= 0) {
                unset($cart[$menuId]);
                $msg = 'Item dihapus dari keranjang';
            } else {
                $cart[$menuId]['quantity'] = $quantity;
                $msg = 'Jumlah pesanan diperbarui';
            }
            session(['cart' => $cart]);

            if ($request->wantsJson() || $request->ajax()) {
                $total = 0;
                $itemSubtotal = isset($cart[$menuId]) ? $cart[$menuId]['harga'] * $cart[$menuId]['quantity'] : 0;
                $itemCount = 0;
                foreach ($cart as $it) {
                    $total += $it['harga'] * $it['quantity'];
                    $itemCount += $it['quantity'];
                }
                return response()->json([
                    'success' => true,
                    'message' => $msg,
                    'quantity' => $quantity,
                    'subtotal' => $itemSubtotal,
                    'subtotal_formatted' => 'Rp ' . number_format($itemSubtotal, 0, ',', '.'),
                    'total' => $total,
                    'total_formatted' => 'Rp ' . number_format($total, 0, ',', '.'),
                    'item_count' => $itemCount,
                    'cart_count' => count($cart),
                ]);
            }

            return back()->with('success', $msg);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => false, 'message' => 'Item tidak ditemukan'], 404);
        }

        return back()->with('error', 'Item tidak ditemukan di keranjang');
    }

    /**
     * Kosongkan seluruh cart
     */
    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->route('cart.view')->with('success', 'Keranjang berhasil dikosongkan');
    }

    /**
     * Hapus item dari cart
     */
    public function removeFromCart($menuId)
    {
        $cart = session('cart', []);
        unset($cart[$menuId]);
        session(['cart' => $cart]);

        if (request()->wantsJson() || request()->ajax()) {
            $total = 0;
            $itemCount = 0;
            foreach ($cart as $it) {
                $total += $it['harga'] * $it['quantity'];
                $itemCount += $it['quantity'];
            }
            return response()->json([
                'success' => true,
                'message' => 'Item berhasil dihapus',
                'total' => $total,
                'total_formatted' => 'Rp ' . number_format($total, 0, ',', '.'),
                'item_count' => $itemCount,
                'cart_count' => count($cart),
            ]);
        }

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
            'nama_pemesan' => 'required|string|max:100',
            'tipe_pesanan' => 'required|in:Dine In,Take Away',
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
            'nama_pelanggan' => $validated['nama_pemesan'],
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
