<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Admin/Main Dashboard
     */
    public function index()
    {
        if (! auth()->check()) {
            return redirect('/login');
        }

        // Redirect berdasarkan role
        if (auth()->user()->role === 'pemilik') {
            return redirect()->route('pemilik.dashboard');
        } elseif (auth()->user()->role === 'kasir') {
            return redirect()->route('kasir.pesanan');
        }

        // Admin Dashboard
        $today = Carbon::now();

        // Revenue today (completed payments)
        $revenueToday = Order::whereHas('pembayaran', function ($query) {
            $query->where('status_bayar', 'lunas');
        })
            ->whereDate('created_at', $today->format('Y-m-d'))
            ->sum('total_bayar');

        // New orders today
        $ordersToday = Order::whereDate('created_at', $today->format('Y-m-d'))->count();

        // Active menus
        $activeMenus = Menu::where('is_available', true)->count();

        // Pending orders
        $pendingOrders = Order::where('status_order', 'pending')->count();

        // Recent orders
        $recentOrders = Order::with(['orderItems.menu', 'pembayaran'])
            ->latest('created_at')
            ->limit(5)
            ->get();

        // This month stats
        $thisMonth = Carbon::now()->month;
        $thisYear = Carbon::now()->year;

        $monthlyRevenue = Order::whereHas('pembayaran', function ($query) {
            $query->where('status_bayar', 'lunas');
        })
            ->whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->sum('total_bayar');

        $monthlyOrders = Order::whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)
            ->count();

        // Users count
        $totalUsers = User::count();

        return view('admin.dashboard', compact(
            'revenueToday',
            'ordersToday',
            'activeMenus',
            'pendingOrders',
            'recentOrders',
            'monthlyRevenue',
            'monthlyOrders',
            'totalUsers'
        ));
    }
}
