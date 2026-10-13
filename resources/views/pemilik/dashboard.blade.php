@extends('layouts.app')

@section('title', 'Dashboard Pemilik')

@section('content')
	<div class="mb-8">
		<h1 class="text-2xl font-bold text-white">Laporan Pendapatan</h1>
		<p class="mt-1 text-sm text-slate-400">
			Bulan: <strong class="text-slate-200">{{ \Carbon\Carbon::createFromDate($thisYear, $thisMonth, 1)->format('F Y') }}</strong>
		</p>
	</div>

	<!-- KPI Cards -->
	<div class="stagger-children mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
		<div class="glass-card card-hover rounded-2xl p-6">
			<div class="flex items-start justify-between">
				<div>
					<p class="text-xs font-medium uppercase tracking-wider text-slate-400">Total Pendapatan</p>
					<p class="mt-2 text-2xl font-bold text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
				</div>
				<div class="flex h-10 w-10 items-center justify-center rounded-xl gradient-success shadow-lg shadow-emerald-500/20">
					<svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" /></svg>
				</div>
			</div>
		</div>
		<div class="glass-card card-hover rounded-2xl p-6">
			<div class="flex items-start justify-between">
				<div>
					<p class="text-xs font-medium uppercase tracking-wider text-slate-400">Total Pesanan</p>
					<p class="mt-2 text-2xl font-bold text-white">{{ $totalOrders }}</p>
				</div>
				<div class="flex h-10 w-10 items-center justify-center rounded-xl gradient-primary shadow-lg shadow-pink-500/20">
					<svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-0.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l0.35-0.64c.09-.17.23-.31.4-.38L10.1 13h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-0.9-2-2-2z" /></svg>
				</div>
			</div>
		</div>
		<div class="glass-card card-hover rounded-2xl p-6">
			<div class="flex items-start justify-between">
				<div>
					<p class="text-xs font-medium uppercase tracking-wider text-slate-400">Menunggu Pembayaran</p>
					<p class="mt-2 text-2xl font-bold text-white">Rp {{ number_format($pendingPayments, 0, ',', '.') }}</p>
				</div>
				<div class="flex h-10 w-10 items-center justify-center rounded-xl gradient-secondary shadow-lg shadow-amber-500/20">
					<svg class="h-5 w-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z" /></svg>
				</div>
			</div>
		</div>
	</div>

	<!-- Charts Row 1 -->
	<div class="mb-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
		<div class="glass-card rounded-2xl p-6">
			<h3 class="mb-4 text-base font-bold text-white">Pendapatan Harian (30 Hari Terakhir)</h3>
			<canvas id="dailyChart"></canvas>
		</div>
		<div class="glass-card rounded-2xl p-6">
			<h3 class="mb-4 text-base font-bold text-white">Pendapatan Bulanan (12 Bulan)</h3>
			<canvas id="monthlyChart"></canvas>
		</div>
	</div>

	<!-- Charts Row 2 -->
	<div class="mb-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
		<div class="glass-card rounded-2xl p-6">
			<h3 class="mb-4 text-base font-bold text-white">Pendapatan per Kategori</h3>
			@if (count($categoryLabels) > 0)
				<canvas id="categoryChart"></canvas>
			@else
				<canvas id="categoryChart" class="hidden"></canvas>
				<div class="flex flex-col items-center justify-center py-10 text-center">
					<svg class="mb-3 h-12 w-12 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
						<path stroke-linecap="round" stroke-linejoin="round" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
						<path stroke-linecap="round" stroke-linejoin="round" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
					</svg>
					<p class="text-sm font-medium text-slate-400">Belum ada data kategori</p>
					<p class="mt-1 text-xs text-slate-500">Data akan muncul saat ada transaksi bulan ini</p>
				</div>
			@endif
		</div>
		<div class="glass-card overflow-hidden rounded-2xl">
			<div class="p-6 pb-3"><h3 class="text-base font-bold text-white">5 Menu Terlaris</h3></div>
			<div class="overflow-x-auto">
				<table class="w-full text-sm">
					<thead>
						<tr class="border-b border-white/5">
							<th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Menu</th>
							<th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-400">Qty</th>
							<th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-400">Revenue</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-white/5">
						@forelse ($topMenus as $menu)
							<tr class="hover:bg-white/[0.02]">
								<td class="px-5 py-3 text-slate-300">{{ $menu->nama_menu }}</td>
								<td class="px-5 py-3 text-right font-medium text-slate-200">{{ $menu->total_qty }}</td>
								<td class="px-5 py-3 text-right font-medium text-emerald-400">Rp {{ number_format($menu->total_revenue, 0, ',', '.') }}</td>
							</tr>
						@empty
							<tr>
								<td colspan="3" class="px-5 py-8 text-center">
									<p class="text-sm text-slate-500">Belum ada data penjualan bulan ini</p>
								</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script>
		Chart.defaults.color = '#94a3b8';
		Chart.defaults.borderColor = 'rgba(148,163,184,0.08)';

		const dailyCtx = document.getElementById('dailyChart').getContext('2d');
		new Chart(dailyCtx, {
			type: 'line',
			data: {
				labels: {!! json_encode($dailyLabels) !!},
				datasets: [{
					label: 'Pendapatan (Rp)',
					data: {!! json_encode($dailyRevenue) !!},
					borderColor: '#ec4899',
					backgroundColor: 'rgba(236,72,153,0.08)',
					borderWidth: 2, fill: true, tension: 0.4,
					pointBackgroundColor: '#ec4899', pointBorderColor: '#0f172a', pointBorderWidth: 2, pointRadius: 3, pointHoverRadius: 5
				}]
			},
			options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') } } } }
		});

		const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
		new Chart(monthlyCtx, {
			type: 'bar',
			data: {
				labels: {!! json_encode($monthlyLabels) !!},
				datasets: [{
					label: 'Pendapatan (Rp)',
					data: {!! json_encode($monthlyRevenue) !!},
					backgroundColor: 'rgba(236,72,153,0.6)', borderColor: '#ec4899', borderWidth: 1, borderRadius: 8, hoverBackgroundColor: '#ec4899'
				}]
			},
			options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') } } } }
		});

		@if (count($categoryLabels) > 0)
			const categoryCtx = document.getElementById('categoryChart').getContext('2d');
			new Chart(categoryCtx, {
				type: 'doughnut',
				data: {
					labels: {!! json_encode($categoryLabels) !!},
					datasets: [{ data: {!! json_encode($categoryValues) !!}, backgroundColor: ['rgba(236,72,153,0.7)','rgba(59,130,246,0.7)','rgba(16,185,129,0.7)','rgba(245,158,11,0.7)','rgba(139,92,246,0.7)'], borderColor: '#0f172a', borderWidth: 3 }]
				},
				options: { responsive: true, maintainAspectRatio: true, plugins: { legend: { position: 'bottom', labels: { padding: 16 } } } }
			});
		@endif

		// Export Laporan
		const exportBtn = document.getElementById('btn-export');
		if (exportBtn) {
			exportBtn.addEventListener('click', () => {
				window.location.href = '{{ route("pemilik.export") }}';
			});
		}
	</script>
@endpush
