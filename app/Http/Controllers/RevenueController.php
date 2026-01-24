<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RevenueController extends Controller
{
    /**
     * Dashboard Pemilik - Lihat laporan pendapatan
     */
    public function dashboard()
    {
        // Check if user is pemilik
        if (!auth()->check() || auth()->user()->role !== 'pemilik') {
            return redirect('/login')->with('error', 'Akses hanya untuk pemilik');
        }

        // Get current month revenue
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;

        // Revenue dari orders yang sudah lunas (join dengan pembayarans)
        $totalRevenue = Order::whereHas('pembayaran', function ($query) {
            $query->where('status_bayar', 'lunas');
        })
            ->whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->sum('total_bayar');

        // Total orders this month
        $totalOrders = Order::whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->count();

        // Pending payments
        $pendingPayments = Order::whereHas('pembayaran', function ($query) {
            $query->where('status_bayar', 'pending');
        })->sum('total_bayar');

        // Daily revenue for chart (last 30 days)
        $dailyRevenue = [];
        $dailyLabels = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dailyLabels[] = $date->format('d M');

            $revenue = Order::whereHas('pembayaran', function ($query) {
                $query->where('status_bayar', 'lunas');
            })
                ->whereDate('created_at', $date->format('Y-m-d'))
                ->sum('total_bayar');

            $dailyRevenue[] = (int)$revenue;
        }

        // Monthly revenue for chart (last 12 months)
        $monthlyRevenue = [];
        $monthlyLabels = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthlyLabels[] = $date->format('M Y');

            $revenue = Order::whereHas('pembayaran', function ($query) {
                $query->where('status_bayar', 'lunas');
            })
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total_bayar');

            $monthlyRevenue[] = (int)$revenue;
        }

        // Revenue by category (menu categories)
        $categoryRevenue = \DB::table('order_items')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id_menu')
            ->join('kategoris', 'menus.kategori_id', '=', 'kategoris.id_kategori')
            ->join('orders', 'order_items.order_id', '=', 'orders.id_order')
            ->join('pembayarans', 'orders.id_order', '=', 'pembayarans.order_id')
            ->where('pembayarans.status_bayar', 'lunas')
            ->whereMonth('pembayarans.created_at', $thisMonth)
            ->whereYear('pembayarans.created_at', $thisYear)
            ->select('kategoris.nama_kategori', \DB::raw('SUM(order_items.subtotal) as total'))
            ->groupBy('kategoris.nama_kategori')
            ->get();

        $categoryLabels = $categoryRevenue->pluck('nama_kategori')->toArray();
        $categoryValues = $categoryRevenue->pluck('total')->map(fn($v) => (int)$v)->toArray();

        // Top selling menus
        $topMenus = \DB::table('order_items')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id_menu')
            ->join('orders', 'order_items.order_id', '=', 'orders.id_order')
            ->join('pembayarans', 'orders.id_order', '=', 'pembayarans.order_id')
            ->where('pembayarans.status_bayar', 'lunas')
            ->whereMonth('pembayarans.created_at', $thisMonth)
            ->whereYear('pembayarans.created_at', $thisYear)
            ->select('menus.nama_menu', \DB::raw('SUM(order_items.jumlah) as total_qty'), \DB::raw('SUM(order_items.subtotal) as total_revenue'))
            ->groupBy('menus.id_menu', 'menus.nama_menu')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        return view('pemilik.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'pendingPayments',
            'dailyRevenue',
            'dailyLabels',
            'monthlyRevenue',
            'monthlyLabels',
            'categoryLabels',
            'categoryValues',
            'topMenus',
            'thisMonth',
            'thisYear'
        ));
    }

    /**
     * Export laporan pendapatan
     */
    public function exportReport(Request $request)
    {
        if (!auth()->check() || auth()->user()->role !== 'pemilik') {
            return redirect('/login');
        }

        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $payments = Pembayaran::where('status', 'completed')
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->with('order')
            ->orderBy('created_at', 'desc')
            ->get();

        // Generate CSV or PDF here
        return response()->json([
            'total' => $payments->sum('jumlah_bayar'),
            'count' => $payments->count(),
        ]);
    }
}
