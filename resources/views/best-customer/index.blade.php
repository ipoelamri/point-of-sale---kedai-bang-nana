@extends('layouts.app')

@section('title', 'Pelanggan Terbaik')

@section('content')
	<div class="space-y-6">
		<!-- Header -->
		<div class="mb-2">
			<h1 class="text-2xl font-bold text-white">Pelanggan Terbaik</h1>
			<p class="mt-1 text-sm text-slate-400">Analisis pelanggan terbaik berdasarkan pengeluaran dan aktivitas pembelian</p>
		</div>

		<!-- Summary Cards -->
		<div class="stagger-children grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
			<div class="glass-card card-hover rounded-2xl p-5">
				<div class="flex items-center justify-between">
					<div>
						<p class="text-xs font-medium uppercase tracking-wider text-slate-400">Pelanggan Unik</p>
						<p class="mt-1 text-2xl font-bold text-white">{{ number_format($summaryStats->total_unique_customers ?? 0) }}</p>
					</div>
					<div class="flex h-10 w-10 items-center justify-center rounded-xl gradient-info shadow-lg shadow-blue-500/20">
						<svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
					</div>
				</div>
			</div>
			<div class="glass-card card-hover rounded-2xl p-5">
				<div class="flex items-center justify-between">
					<div>
						<p class="text-xs font-medium uppercase tracking-wider text-slate-400">Total Transaksi</p>
						<p class="mt-1 text-2xl font-bold text-white">{{ number_format($summaryStats->total_transactions ?? 0) }}</p>
					</div>
					<div class="flex h-10 w-10 items-center justify-center rounded-xl gradient-success shadow-lg shadow-emerald-500/20">
						<svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
					</div>
				</div>
			</div>
			<div class="glass-card card-hover rounded-2xl p-5">
				<div class="flex items-center justify-between">
					<div>
						<p class="text-xs font-medium uppercase tracking-wider text-slate-400">Total Pendapatan</p>
						<p class="mt-1 text-2xl font-bold text-white">Rp {{ number_format($summaryStats->total_revenue ?? 0, 0, ',', '.') }}</p>
					</div>
					<div class="flex h-10 w-10 items-center justify-center rounded-xl gradient-secondary shadow-lg shadow-amber-500/20">
						<svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01" /></svg>
					</div>
				</div>
			</div>
			<div class="glass-card card-hover rounded-2xl p-5">
				<div class="flex items-center justify-between">
					<div>
						<p class="text-xs font-medium uppercase tracking-wider text-slate-400">Rata-rata Transaksi</p>
						<p class="mt-1 text-2xl font-bold text-white">Rp {{ number_format($summaryStats->avg_transaction ?? 0, 0, ',', '.') }}</p>
					</div>
					<div class="flex h-10 w-10 items-center justify-center rounded-xl gradient-accent shadow-lg shadow-violet-500/20">
						<svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
					</div>
				</div>
			</div>
		</div>

		<!-- Filters -->
		<div class="glass-card rounded-2xl p-5">
			<form method="GET" class="space-y-4">
				<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
					<div>
						<label for="period_type" class="form-label">📅 Rentang Waktu</label>
						<select name="period_type" id="period_type" class="form-input">
							<option value="harian" {{ $periodType == 'harian' ? 'selected' : '' }}>Harian (1 Hari)</option>
							<option value="bulan" {{ $periodType == 'bulan' ? 'selected' : '' }}>Bulanan (30 Hari)</option>
							<option value="tahun" {{ $periodType == 'tahun' ? 'selected' : '' }}>Tahunan (365 Hari)</option>
						</select>
					</div>
					<div>
						<label for="top_limit" class="form-label">🏆 Batasan Peringkat</label>
						<select name="top_limit" id="top_limit" class="form-input">
							@foreach([5,10,15,20,30,50] as $v)
								<option value="{{ $v }}" {{ $topLimit == $v ? 'selected' : '' }}>Top {{ $v }}</option>
							@endforeach
						</select>
					</div>
					<div>
						<label for="sort_by" class="form-label">⬇️ Urutkan</label>
						<select name="sort_by" id="sort_by" class="form-input">
							<option value="total_spending" {{ $sortBy == 'total_spending' ? 'selected' : '' }}>Total Pengeluaran</option>
							<option value="total_orders" {{ $sortBy == 'total_orders' ? 'selected' : '' }}>Jumlah Pesanan</option>
							<option value="last_order" {{ $sortBy == 'last_order' ? 'selected' : '' }}>Pesanan Terakhir</option>
						</select>
					</div>
					<div class="flex flex-col justify-end">
						<button type="submit" class="btn btn-primary">Tampilkan</button>
					</div>
				</div>
				<div class="flex flex-col gap-2 border-t border-white/5 pt-3 sm:flex-row">
					<a href="{{ route('best-customer.export', ['period_type' => $periodType, 'top_limit' => $topLimit, 'sort_by' => $sortBy]) }}"
						class="btn text-sm" style="background:rgba(16,185,129,0.15);color:#34d399;border:1px solid rgba(16,185,129,0.2);">Unduh CSV</a>
					<a href="{{ route('best-customer.export-pdf', ['period_type' => $periodType, 'top_limit' => $topLimit, 'sort_by' => $sortBy]) }}"
						target="_blank" class="btn text-sm" style="background:rgba(239,68,68,0.15);color:#f87171;border:1px solid rgba(239,68,68,0.2);">📄 Unduh PDF</a>
				</div>
			</form>
		</div>

		<!-- Table -->
		<div class="glass-card overflow-hidden rounded-2xl">
			<div class="p-5 pb-0"><h2 class="text-lg font-bold text-white">Daftar Pelanggan Terbaik</h2></div>
			@if ($bestCustomers->count() > 0)
				<div class="overflow-x-auto mt-4">
					<table class="w-full text-sm">
						<thead>
							<tr class="border-b border-white/5">
								<th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Rank</th>
								<th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Nama</th>
								<th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-400">Pesanan</th>
								<th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-400">Total</th>
								<th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-400">Rata-rata</th>
								<th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-400">Terakhir</th>
								<th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-400">Aksi</th>
							</tr>
						</thead>
						<tbody class="divide-y divide-white/5">
							@foreach ($bestCustomers as $customer)
								<tr class="hover:bg-white/[0.02]">
									<td class="px-5 py-3">
										@if ($customer->rank <= 3)
											<span class="text-lg">{{ ['🥇','🥈','🥉'][$customer->rank - 1] }}</span>
										@else
											<span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-slate-700 text-xs font-bold text-white">{{ $customer->rank }}</span>
										@endif
									</td>
									<td class="px-5 py-3 font-semibold text-white">{{ $customer->nama_pelanggan }}</td>
									<td class="px-5 py-3 text-center"><span class="badge badge-info">{{ $customer->total_orders }}</span></td>
									<td class="px-5 py-3 text-right font-semibold text-emerald-400">Rp {{ number_format($customer->total_spending, 0, ',', '.') }}</td>
									<td class="px-5 py-3 text-right text-slate-300">Rp {{ number_format($customer->avg_spending, 0, ',', '.') }}</td>
									<td class="px-5 py-3 text-center text-xs text-slate-400">{{ $customer->last_order_date->format('d/m/Y H:i') }}</td>
									<td class="px-5 py-3 text-center">
										<a href="{{ route('best-customer.show', ['customerName' => urlencode($customer->nama_pelanggan)]) }}" class="btn btn-primary text-xs py-1 px-3">Detail</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="border-t border-white/5 px-5 py-4 flex justify-center">
					{{ $bestCustomers->appends(request()->query())->links() }}
				</div>
			@else
				<div class="py-12 text-center">
					<p class="text-4xl mb-3">📭</p>
					<p class="text-slate-400">Belum ada data pelanggan untuk periode ini</p>
				</div>
			@endif
		</div>
	</div>
@endsection
