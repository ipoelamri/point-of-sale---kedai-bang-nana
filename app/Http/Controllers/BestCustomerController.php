<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BestCustomerController extends Controller
{
    /**
     * Display the best customers list.
     */
    public function index(Request $request)
    {
        // Get parameters from request
        $periodType = $request->input('period_type', 'bulan');  // harian, bulan, tahun
        $topLimit = (int) $request->input('top_limit', 15);
        $sortBy = $request->input('sort_by', 'total_spending');

        // Determine number of days based on period type
        $daysMap = [
            'harian' => 1,
            'bulan' => 30,
            'tahun' => 365,
        ];
        $days = $daysMap[$periodType] ?? 30;

        // Calculate date range
        $startDate = now()->subDays($days);

        // Query untuk mendapatkan pelanggan terbaik dengan berbagai kriteria
        $bestCustomers = Order::where('status_order', 'selesai')
            ->where('created_at', '>=', $startDate)
            ->where('nama_pelanggan', '!=', '')
            ->select(
                'nama_pelanggan',
                DB::raw('COUNT(id_order) as total_orders'),
                DB::raw('SUM(total_bayar) as total_spending'),
                DB::raw('AVG(total_bayar) as avg_spending'),
                DB::raw('MAX(created_at) as last_order_date'),
                DB::raw('MIN(created_at) as first_order_date')
            )
            ->groupBy('nama_pelanggan');

        // Sort berdasarkan parameter
        if ($sortBy === 'total_orders') {
            $bestCustomers->orderByDesc('total_orders');
        } elseif ($sortBy === 'last_order') {
            $bestCustomers->orderByDesc('last_order_date');
        } else {
            // Default: sort by total spending
            $bestCustomers->orderByDesc('total_spending');
        }

        // Get all results before pagination for limiting
        $allResults = $bestCustomers->get();

        // Apply top limit
        $limitedResults = $allResults->take($topLimit);

        // Manually create pagination
        $page = $request->get('page', 1);
        $itemsPerPage = 15;
        $offset = ($page - 1) * $itemsPerPage;

        $bestCustomers = new \Illuminate\Pagination\LengthAwarePaginator(
            $limitedResults->slice($offset, $itemsPerPage)->values(),
            $limitedResults->count(),
            $itemsPerPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        // Add ranking
        $customers = $bestCustomers->getCollection()->map(function ($customer, $index) use ($page, $itemsPerPage) {
            $customer->rank = ($page - 1) * $itemsPerPage + $index + 1;
            // Convert string dates to Carbon objects
            $customer->last_order_date = \Carbon\Carbon::parse($customer->last_order_date);
            $customer->first_order_date = \Carbon\Carbon::parse($customer->first_order_date);

            return $customer;
        });
        $bestCustomers->setCollection($customers);

        // Get summary statistics
        $summaryStats = Order::where('status_order', 'selesai')
            ->where('created_at', '>=', $startDate)
            ->where('nama_pelanggan', '!=', '')
            ->select(
                DB::raw('COUNT(DISTINCT nama_pelanggan) as total_unique_customers'),
                DB::raw('COUNT(id_order) as total_transactions'),
                DB::raw('SUM(total_bayar) as total_revenue'),
                DB::raw('AVG(total_bayar) as avg_transaction')
            )
            ->first();

        return view('best-customer.index', compact('bestCustomers', 'summaryStats', 'periodType', 'topLimit', 'sortBy', 'days'));
    }

    /**
     * Show detail pelanggan tertentu.
     */
    public function show($customerName)
    {
        $period = request()->input('period', 30);
        $startDate = now()->subDays($period);

        // Detail pelanggan
        $customerOrders = Order::where('status_order', 'selesai')
            ->where('nama_pelanggan', $customerName)
            ->where('created_at', '>=', $startDate)
            ->with(['orderItems', 'pembayaran'])
            ->orderByDesc('created_at')
            ->paginate(10);

        // Summary untuk pelanggan ini
        $customerStats = Order::where('status_order', 'selesai')
            ->where('nama_pelanggan', $customerName)
            ->where('created_at', '>=', $startDate)
            ->select(
                DB::raw('COUNT(id_order) as total_orders'),
                DB::raw('SUM(total_bayar) as total_spending'),
                DB::raw('AVG(total_bayar) as avg_spending'),
                DB::raw('MAX(created_at) as last_order_date'),
                DB::raw('MIN(created_at) as first_order_date')
            )
            ->first();

        // Convert string dates to Carbon objects
        if ($customerStats) {
            $customerStats->last_order_date = \Carbon\Carbon::parse($customerStats->last_order_date);
            $customerStats->first_order_date = \Carbon\Carbon::parse($customerStats->first_order_date);
        }

        return view('best-customer.show', compact('customerName', 'customerOrders', 'customerStats', 'period'));
    }

    /**
     * Export data pelanggan terbaik ke CSV.
     */
    public function export(Request $request)
    {
        $periodType = $request->input('period_type', 'bulan');
        $topLimit = (int) $request->input('top_limit', 15);
        $sortBy = $request->input('sort_by', 'total_spending');

        // Determine number of days
        $daysMap = [
            'harian' => 1,
            'bulan' => 30,
            'tahun' => 365,
        ];
        $days = $daysMap[$periodType] ?? 30;
        $startDate = now()->subDays($days);

        $bestCustomers = Order::where('status_order', 'selesai')
            ->where('created_at', '>=', $startDate)
            ->where('nama_pelanggan', '!=', '')
            ->select(
                'nama_pelanggan',
                DB::raw('COUNT(id_order) as total_orders'),
                DB::raw('SUM(total_bayar) as total_spending'),
                DB::raw('AVG(total_bayar) as avg_spending'),
                DB::raw('MAX(created_at) as last_order_date')
            )
            ->groupBy('nama_pelanggan');

        if ($sortBy === 'total_orders') {
            $bestCustomers->orderByDesc('total_orders');
        } elseif ($sortBy === 'last_order') {
            $bestCustomers->orderByDesc('last_order_date');
        } else {
            $bestCustomers->orderByDesc('total_spending');
        }

        $bestCustomers = $bestCustomers->get()->take($topLimit);

        $filename = 'laporan-pelanggan-terbaik-'.now()->format('Y-m-d-His').'.csv';

        $headers = [
            'Content-type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=$filename",
        ];

        $columns = ['Peringkat', 'Nama Pelanggan', 'Total Pesanan', 'Total Pengeluaran', 'Rata-rata Pesanan', 'Pesanan Terakhir'];

        // Convert string dates to Carbon objects
        $bestCustomers = $bestCustomers->map(function ($customer) {
            $customer->last_order_date = \Carbon\Carbon::parse($customer->last_order_date);

            return $customer;
        });

        $callback = function () use ($bestCustomers, $columns) {
            $file = fopen('php://output', 'w');
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $columns, ';');

            foreach ($bestCustomers as $index => $customer) {
                fputcsv($file, [
                    $index + 1,
                    $customer->nama_pelanggan,
                    $customer->total_orders,
                    $customer->total_spending,
                    round($customer->avg_spending, 2),
                    $customer->last_order_date->format('d-m-Y H:i'),
                ], ';');
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export data ke PDF (print-friendly view).
     */
    public function exportPdf(Request $request)
    {
        $periodType = $request->input('period_type', 'bulan');
        $topLimit = (int) $request->input('top_limit', 15);
        $sortBy = $request->input('sort_by', 'total_spending');

        // Determine number of days
        $daysMap = [
            'harian' => 1,
            'bulan' => 30,
            'tahun' => 365,
        ];
        $days = $daysMap[$periodType] ?? 30;
        $startDate = now()->subDays($days);

        // Get period label
        $periodLabels = [
            'harian' => 'Harian (1 Hari)',
            'bulan' => 'Bulanan (30 Hari)',
            'tahun' => 'Tahunan (365 Hari)',
        ];
        $periodLabel = $periodLabels[$periodType] ?? 'Bulanan';

        $bestCustomers = Order::where('status_order', 'selesai')
            ->where('created_at', '>=', $startDate)
            ->where('nama_pelanggan', '!=', '')
            ->select(
                'nama_pelanggan',
                DB::raw('COUNT(id_order) as total_orders'),
                DB::raw('SUM(total_bayar) as total_spending'),
                DB::raw('AVG(total_bayar) as avg_spending'),
                DB::raw('MAX(created_at) as last_order_date'),
                DB::raw('MIN(created_at) as first_order_date')
            )
            ->groupBy('nama_pelanggan');

        if ($sortBy === 'total_orders') {
            $bestCustomers->orderByDesc('total_orders');
        } elseif ($sortBy === 'last_order') {
            $bestCustomers->orderByDesc('last_order_date');
        } else {
            $bestCustomers->orderByDesc('total_spending');
        }

        $bestCustomers = $bestCustomers->get()->take($topLimit);

        // Convert string dates to Carbon objects
        $bestCustomers = $bestCustomers->map(function ($customer) {
            $customer->last_order_date = \Carbon\Carbon::parse($customer->last_order_date);
            $customer->first_order_date = \Carbon\Carbon::parse($customer->first_order_date);

            return $customer;
        });

        // Get summary statistics
        $summaryStats = Order::where('status_order', 'selesai')
            ->where('created_at', '>=', $startDate)
            ->where('nama_pelanggan', '!=', '')
            ->select(
                DB::raw('COUNT(DISTINCT nama_pelanggan) as total_unique_customers'),
                DB::raw('COUNT(id_order) as total_transactions'),
                DB::raw('SUM(total_bayar) as total_revenue'),
                DB::raw('AVG(total_bayar) as avg_transaction')
            )
            ->first();

        return view('best-customer.pdf', compact('bestCustomers', 'summaryStats', 'periodLabel', 'topLimit'));
    }
}
