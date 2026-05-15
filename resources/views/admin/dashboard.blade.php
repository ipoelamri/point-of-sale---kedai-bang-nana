@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
	<div class="mb-8">
		<h1 class="text-2xl font-bold text-white">Dashboard</h1>
		<p class="mt-1 text-sm text-slate-400">Ringkasan aktivitas kedai hari ini</p>
	</div>

	<!-- Stat Cards -->
	<div class="stagger-children mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">

		<!-- Card 1: Pendapatan Hari Ini -->
		<div class="glass-card card-hover rounded-2xl p-6">
			<div class="flex items-center gap-4">
				<div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl gradient-secondary shadow-lg shadow-amber-500/20">
					<svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
						stroke="currentColor" stroke-width="2">
						<path stroke-linecap="round" stroke-linejoin="round"
							d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01" />
					</svg>
				</div>
				<div>
					<p class="text-xs font-medium uppercase tracking-wider text-slate-400">Pendapatan Hari Ini</p>
					<p class="mt-1 text-2xl font-bold text-white">Rp {{ number_format($revenueToday, 0, ',', '.') }}</p>
				</div>
			</div>
		</div>

		<!-- Card 2: Pesanan Baru -->
		<div class="glass-card card-hover rounded-2xl p-6">
			<div class="flex items-center gap-4">
				<div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl gradient-primary shadow-lg shadow-pink-500/20">
					<svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
						stroke="currentColor" stroke-width="2">
						<path stroke-linecap="round" stroke-linejoin="round"
							d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
					</svg>
				</div>
				<div>
					<p class="text-xs font-medium uppercase tracking-wider text-slate-400">Pesanan Hari Ini</p>
					<p class="mt-1 text-2xl font-bold text-white">{{ $ordersToday }}</p>
				</div>
			</div>
		</div>

		<!-- Card 3: Menu Aktif -->
		<div class="glass-card card-hover rounded-2xl p-6">
			<div class="flex items-center gap-4">
				<div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl gradient-success shadow-lg shadow-emerald-500/20">
					<svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
						stroke="currentColor" stroke-width="2">
						<path stroke-linecap="round" stroke-linejoin="round"
							d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
					</svg>
				</div>
				<div>
					<p class="text-xs font-medium uppercase tracking-wider text-slate-400">Menu Aktif</p>
					<p class="mt-1 text-2xl font-bold text-white">{{ $activeMenus }}</p>
				</div>
			</div>
		</div>
	</div>

	<!-- Recent Activity -->
	<div class="glass-card rounded-2xl p-6">
		<h3 class="mb-5 text-lg font-bold text-white">Pesanan Terbaru</h3>
		<div class="overflow-x-auto">
			<table class="w-full text-sm">
				<thead>
					<tr class="border-b border-white/5">
						<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">No. Pesanan</th>
						<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Pelanggan</th>
						<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Total</th>
						<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Status</th>
						<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Pembayaran</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-white/5">
					@forelse ($recentOrders as $order)
						<tr class="transition-colors hover:bg-white/[0.02]">
							<td class="px-4 py-3 font-medium text-slate-200">{{ $order->no_order }}</td>
							<td class="px-4 py-3 text-slate-300">{{ $order->nama_pelanggan }}</td>
							<td class="px-4 py-3 font-medium text-slate-200">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
							<td class="px-4 py-3">
								<span class="badge
									@if ($order->status_order === 'pending') badge-warning
									@elseif($order->status_order === 'diproses') badge-info
									@elseif($order->status_order === 'selesai') badge-success
									@else badge-neutral @endif">
									{{ ucfirst($order->status_order) }}
								</span>
							</td>
							<td class="px-4 py-3">
								@if ($order->pembayaran)
									<span class="badge
										@if ($order->pembayaran->status_bayar === 'completed') badge-success
										@elseif($order->pembayaran->status_bayar === 'pending') badge-warning
										@else badge-danger @endif">
										{{ ucfirst($order->pembayaran->status_bayar) }}
									</span>
								@else
									<span class="text-slate-600">—</span>
								@endif
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="5" class="px-4 py-8 text-center text-slate-500">Belum ada pesanan</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
@endsection
