@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
	<h1 class="mb-6 rounded-lg px-6 py-3 text-3xl font-bold text-white"
		style="background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);">Dashboard</h1>

	<!-- Stat Cards -->
	<div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

		<!-- Card 1: Pendapatan Hari Ini -->
		<div class="flex items-center rounded-xl bg-slate-800 p-6 shadow-md">
			<!-- Heroicon: currency-dollar -->
			<div class="rounded-full p-3" style="background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);">
				<svg class="h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
					stroke="currentColor">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
						d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01" />
				</svg>
			</div>
			<div class="ml-4">
				<h3 class="text-slate-400">Pendapatan Hari Ini</h3>
				<p class="text-2xl font-bold text-white">Rp {{ number_format($revenueToday, 0, ',', '.') }}</p>
			</div>
		</div>

		<!-- Card 2: Pesanan Baru -->
		<div class="flex items-center rounded-xl bg-slate-800 p-6 shadow-md">
			<!-- Heroicon: shopping-bag -->
			<div class="rounded-full p-3" style="background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);">
				<svg class="h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
					stroke="currentColor">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
						d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
				</svg>
			</div>
			<div class="ml-4">
				<h3 class="text-slate-400">Pesanan Hari Ini</h3>
				<p class="text-2xl font-bold text-white">{{ $ordersToday }}</p>
			</div>
		</div>

		<!-- Card 3: Menu Aktif -->
		<div class="flex items-center rounded-xl bg-slate-800 p-6 shadow-md">
			<!-- Heroicon: collection -->
			<div class="rounded-full p-3" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
				<svg class="h-8 w-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
					stroke="currentColor">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
						d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
				</svg>
			</div>
			<div class="ml-4">
				<h3 class="text-slate-400">Menu Aktif</h3>
				<p class="text-2xl font-bold text-white">{{ $activeMenus }}</p>
			</div>
		</div>
	</div>

	<!-- Recent Activity -->
	<div class="mt-8 rounded-xl bg-slate-800 p-6 shadow-md">
		<h3 class="mb-4 text-xl font-bold text-white">Pesanan Terbaru</h3>
		<div class="overflow-x-auto">
			<table class="w-full text-sm">
				<thead class="border-b border-slate-700 bg-slate-900">
					<tr>
						<th class="px-4 py-2 text-left text-slate-300">No. Pesanan</th>
						<th class="px-4 py-2 text-left text-slate-300">Pelanggan</th>
						<th class="px-4 py-2 text-left text-slate-300">Total</th>
						<th class="px-4 py-2 text-left text-slate-300">Status</th>
						<th class="px-4 py-2 text-left text-slate-300">Pembayaran</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-slate-700">
					@forelse ($recentOrders as $order)
						<tr class="hover:bg-slate-700">
							<td class="px-4 py-3 font-medium text-slate-200">{{ $order->no_order }}</td>
							<td class="px-4 py-3 text-slate-200">{{ $order->nama_pelanggan }}</td>
							<td class="px-4 py-3 text-slate-200">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
							<td class="px-4 py-3">
								<span
									class="@if ($order->status_order === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status_order === 'diproses') bg-blue-100 text-blue-800
                                    @elseif($order->status_order === 'selesai') bg-green-100 text-green-800
                                    @else bg-slate-100 text-slate-800 @endif rounded px-2 py-1 text-xs font-medium">
									{{ ucfirst($order->status_order) }}
								</span>
							</td>
							<td class="px-4 py-3">
								@if ($order->pembayaran)
									<span
										class="@if ($order->pembayaran->status_bayar === 'completed') bg-green-100 text-green-800
                                        @elseif($order->pembayaran->status_bayar === 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif rounded px-2 py-1 text-xs font-medium">
										{{ ucfirst($order->pembayaran->status_bayar) }}
									</span>
								@else
									<span class="text-slate-500">-</span>
								@endif
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="5" class="px-4 py-3 text-center text-slate-500">Belum ada pesanan</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
@endsection
