<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

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
