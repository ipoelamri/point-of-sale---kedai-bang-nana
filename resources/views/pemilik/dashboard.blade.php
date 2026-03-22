@extends('layouts.app')

@section('title', 'Dashboard Pemilik')

@section('content')
	<h1 class="mb-2 rounded-lg px-6 py-3 text-3xl font-bold text-white"
		style="background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);">Laporan Pendapatan</h1>
	<p class="mb-6 px-6 text-sm text-slate-400">
		Bulan: <strong>{{ \Carbon\Carbon::createFromDate($thisYear, $thisMonth, 1)->format('F Y') }}</strong>
	</p>

	<!-- KPI Cards -->
	<div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
		<!-- Total Revenue -->
		<div class="rounded-lg bg-slate-900 p-6 shadow-sm">
			<div class="flex items-start justify-between">
				<div>
					<p class="text-sm font-medium text-slate-400">Total Pendapatan</p>
					<p class="mt-2 text-3xl font-bold text-white">
						Rp {{ number_format($totalRevenue, 0, ',', '.') }}
					</p>
				</div>
				<div class="rounded-full p-3" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
					<svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 24 24">
						<path
							d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
					</svg>
				</div>
			</div>
		</div>

		<!-- Total Orders -->
		<div class="rounded-lg bg-slate-900 p-6 shadow-sm">
			<div class="flex items-start justify-between">
				<div>
					<p class="text-sm font-medium text-slate-400">Total Pesanan</p>
					<p class="mt-2 text-3xl font-bold text-white">{{ $totalOrders }}</p>
				</div>
				<div class="rounded-full p-3" style="background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);">
					<svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 24 24">
						<path
							d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-0.9-2-2-2zM1 2v2h2l3.6 7.59-1.35 2.45c-.16.28-.25.61-.25.96 0 1.1.9 2 2 2h12v-2H7.42c-.14 0-.25-.11-.25-.25l0.35-0.64c.09-.17.23-.31.4-.38L10.1 13h7.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49c.08-.14.12-.31.12-.48 0-.55-.45-1-1-1H5.21l-.94-2H1zm16 16c-1.1 0-1.99.9-1.99 2s.89 2 1.99 2 2-.9 2-2-0.9-2-2-2z" />
					</svg>
				</div>
			</div>
		</div>

		<!-- Pending Payments -->
		<div class="rounded-lg bg-slate-900 p-6 shadow-sm">
			<div class="flex items-start justify-between">
				<div>
					<p class="text-sm font-medium text-slate-400">Menunggu Pembayaran</p>
					<p class="mt-2 text-3xl font-bold text-white">
						Rp {{ number_format($pendingPayments, 0, ',', '.') }}
					</p>
				</div>
				<div class="rounded-full p-3" style="background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);">
					<svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 24 24">
						<path d="M1 21h22L12 2 1 21zm12-3h-2v-2h2v2zm0-4h-2v-4h2v4z" />
					</svg>
				</div>
			</div>
		</div>
	</div>

	<!-- Charts Row 1 -->
	<div class="mb-8 grid grid-cols-1 gap-8 lg:grid-cols-2">
		<!-- Daily Revenue Chart -->
		<div class="rounded-lg bg-slate-900 p-6 shadow-sm">
			<h3 class="mb-4 text-lg font-semibold text-white">Pendapatan Harian (30 Hari Terakhir)</h3>
			<canvas id="dailyChart"></canvas>
		</div>

		<!-- Monthly Revenue Chart -->
		<div class="rounded-lg bg-slate-900 p-6 shadow-sm">
			<h3 class="mb-4 text-lg font-semibold text-white">Pendapatan Bulanan (12 Bulan)</h3>
			<canvas id="monthlyChart"></canvas>
		</div>
	</div>

	<!-- Charts Row 2 -->
	<div class="mb-8 grid grid-cols-1 gap-8 lg:grid-cols-2">
		<!-- Category Revenue Chart -->
		<div class="rounded-lg bg-slate-900 p-6 shadow-sm">
			<h3 class="mb-4 text-lg font-semibold text-white">Pendapatan per Kategori</h3>
			<canvas id="categoryChart"></canvas>
		</div>

		<!-- Top Menus Table -->
		<div class="rounded-lg bg-slate-900 p-6 shadow-sm">
			<h3 class="mb-4 text-lg font-semibold text-white">5 Menu Terlaris</h3>
			<div class="overflow-x-auto">
				<table class="w-full text-sm">
					<thead class="border-b border-slate-700 bg-slate-800">
						<tr>
							<th class="px-4 py-2 text-left text-slate-300">Menu</th>
							<th class="px-4 py-2 text-right text-slate-300">Qty</th>
							<th class="px-4 py-2 text-right text-slate-300">Revenue</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-slate-700">
						@foreach ($topMenus as $menu)
							<tr class="hover:bg-slate-800">
								<td class="px-4 py-3 text-slate-300">{{ $menu->nama_menu }}</td>
								<td class="px-4 py-3 text-right font-medium text-slate-300">
									{{ $menu->total_qty }}
								</td>
								<td class="px-4 py-3 text-right text-emerald-400">
									Rp {{ number_format($menu->total_revenue, 0, ',', '.') }}
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script>
		// Daily Revenue Chart
		const dailyCtx = document.getElementById('dailyChart').getContext('2d');
		new Chart(dailyCtx, {
			type: 'line',
			data: {
				labels: {!! json_encode($dailyLabels) !!},
				datasets: [{
					label: 'Pendapatan (Rp)',
					data: {!! json_encode($dailyRevenue) !!},
					borderColor: 'rgb(217, 119, 6)',
					backgroundColor: 'rgba(217, 119, 6, 0.1)',
					borderWidth: 2,
					fill: true,
					tension: 0.4,
					pointBackgroundColor: 'rgb(217, 119, 6)',
					pointBorderColor: '#fff',
					pointBorderWidth: 2,
					pointRadius: 4,
					pointHoverRadius: 6
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: true,
				plugins: {
					legend: {
						display: false
					}
				},
				scales: {
					y: {
						beginAtZero: true,
						ticks: {
							callback: function(value) {
								return 'Rp ' + value.toLocaleString('id-ID');
							}
						}
					}
				}
			}
		});

		// Monthly Revenue Chart
		const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
		new Chart(monthlyCtx, {
			type: 'bar',
			data: {
				labels: {!! json_encode($monthlyLabels) !!},
				datasets: [{
					label: 'Pendapatan (Rp)',
					data: {!! json_encode($monthlyRevenue) !!},
					backgroundColor: 'rgba(217, 119, 6, 0.8)',
					borderColor: 'rgb(217, 119, 6)',
					borderWidth: 1,
					borderRadius: 4,
					hoverBackgroundColor: 'rgb(217, 119, 6)'
				}]
			},
			options: {
				responsive: true,
				maintainAspectRatio: true,
				plugins: {
					legend: {
						display: false
					}
				},
				scales: {
					y: {
						beginAtZero: true,
						ticks: {
							callback: function(value) {
								return 'Rp ' + value.toLocaleString('id-ID');
							}
						}
					}
				}
			}
		});

		// Category Revenue Chart
		@if (count($categoryLabels) > 0)
			const categoryCtx = document.getElementById('categoryChart').getContext('2d');
			new Chart(categoryCtx, {
				type: 'doughnut',
				data: {
					labels: {!! json_encode($categoryLabels) !!},
					datasets: [{
						data: {!! json_encode($categoryValues) !!},
						backgroundColor: [
							'rgba(217, 119, 6, 0.8)',
							'rgba(59, 130, 246, 0.8)',
							'rgba(34, 197, 94, 0.8)',
							'rgba(236, 72, 153, 0.8)',
							'rgba(168, 85, 247, 0.8)',
						],
						borderColor: '#fff',
						borderWidth: 2
					}]
				},
				options: {
					responsive: true,
					maintainAspectRatio: true,
					plugins: {
						legend: {
							position: 'bottom'
						}
					}
				}
			});
		@endif
	</script>
@endpush
