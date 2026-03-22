@extends('layouts.app')

@section('title', 'Pelanggan Terbaik')

@section('content')
	<div class="space-y-6">
		<!-- Header -->
		<div class="rounded-lg px-6 py-4 text-white" style="background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);">
			<h1 class="text-3xl font-bold">Pelanggan Terbaik</h1>
			<p class="mt-2 text-pink-100">Analisis dan laporan pelanggan terbaik berdasarkan pengeluaran dan aktivitas pembelian
			</p>
		</div>

		<!-- Summary Cards -->
		<div class="grid grid-cols-1 gap-4 md:grid-cols-4">
			<!-- Total Customers Card -->
			<div class="rounded-xl bg-slate-800 p-6 shadow-md">
				<div class="flex items-center justify-between">
					<div>
						<p class="text-sm text-slate-400">Pelanggan Unik</p>
						<p class="text-2xl font-bold text-white">{{ number_format($summaryStats->total_unique_customers ?? 0) }}</p>
					</div>
					<div class="rounded-full p-3" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
						<svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
							stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M12 4.354a4 4 0 110 5.292M15 4H9m6 16H9m0-11h6m0 0a2 2 0 100-4 2 2 0 000 4zm0 0a2 2 0 100 4 2 2 0 000-4z" />
						</svg>
					</div>
				</div>
			</div>

			<!-- Total Transactions Card -->
			<div class="rounded-xl bg-slate-800 p-6 shadow-md">
				<div class="flex items-center justify-between">
					<div>
						<p class="text-sm text-slate-400">Total Transaksi</p>
						<p class="text-2xl font-bold text-white">{{ number_format($summaryStats->total_transactions ?? 0) }}</p>
					</div>
					<div class="rounded-full p-3" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
						<svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
							stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
						</svg>
					</div>
				</div>
			</div>

			<!-- Total Revenue Card -->
			<div class="rounded-xl bg-slate-800 p-6 shadow-md">
				<div class="flex items-center justify-between">
					<div>
						<p class="text-sm text-slate-400">Total Pendapatan</p>
						<p class="text-2xl font-bold text-white">Rp {{ number_format($summaryStats->total_revenue ?? 0, 0, ',', '.') }}</p>
					</div>
					<div class="rounded-full p-3" style="background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);">
						<svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
							stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01M12 12v-.01" />
						</svg>
					</div>
				</div>
			</div>

			<!-- Average Transaction Card -->
			<div class="rounded-xl bg-slate-800 p-6 shadow-md">
				<div class="flex items-center justify-between">
					<div>
						<p class="text-sm text-slate-400">Rata-rata Transaksi</p>
						<p class="text-2xl font-bold text-white">Rp {{ number_format($summaryStats->avg_transaction ?? 0, 0, ',', '.') }}
						</p>
					</div>
					<div class="rounded-full p-3" style="background: linear-gradient(135deg, #a78bfa 0%, #7c3aed 100%);">
						<svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
							stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
						</svg>
					</div>
				</div>
			</div>
		</div>

		<!-- Filters & Controls -->
		<div class="rounded-xl bg-slate-800 p-6 shadow-md">
			<form method="GET" class="space-y-4">
				<!-- Filter Row 1: Periode & Top Limit -->
				<div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-4">
					<!-- Period Filter -->
					<div class="flex flex-col gap-2">
						<label for="period_type" class="text-sm font-semibold text-slate-300">📅 Rentang Waktu:</label>
						<select name="period_type" id="period_type"
							class="rounded-lg border border-slate-600 bg-slate-700 px-3 py-2 text-white focus:border-pink-500 focus:outline-none">
							<option value="harian" {{ $periodType == 'harian' ? 'selected' : '' }}>Harian (1 Hari)</option>
							<option value="bulan" {{ $periodType == 'bulan' ? 'selected' : '' }}>Bulanan (30 Hari)</option>
							<option value="tahun" {{ $periodType == 'tahun' ? 'selected' : '' }}>Tahunan (365 Hari)</option>
						</select>
					</div>

					<!-- Top Limit Filter -->
					<div class="flex flex-col gap-2">
						<label for="top_limit" class="text-sm font-semibold text-slate-300">🏆 Batasan Peringkat:</label>
						<select name="top_limit" id="top_limit"
							class="rounded-lg border border-slate-600 bg-slate-700 px-3 py-2 text-white focus:border-pink-500 focus:outline-none">
							<option value="5" {{ $topLimit == 5 ? 'selected' : '' }}>Top 5</option>
							<option value="10" {{ $topLimit == 10 ? 'selected' : '' }}>Top 10</option>
							<option value="15" {{ $topLimit == 15 ? 'selected' : '' }}>Top 15</option>
							<option value="20" {{ $topLimit == 20 ? 'selected' : '' }}>Top 20</option>
							<option value="30" {{ $topLimit == 30 ? 'selected' : '' }}>Top 30</option>
							<option value="50" {{ $topLimit == 50 ? 'selected' : '' }}>Top 50</option>
						</select>
					</div>

					<!-- Sort Filter -->
					<div class="flex flex-col gap-2">
						<label for="sort_by" class="text-sm font-semibold text-slate-300">⬇️ Urutkan:</label>
						<select name="sort_by" id="sort_by"
							class="rounded-lg border border-slate-600 bg-slate-700 px-3 py-2 text-white focus:border-pink-500 focus:outline-none">
							<option value="total_spending" {{ $sortBy == 'total_spending' ? 'selected' : '' }}>Total Pengeluaran</option>
							<option value="total_orders" {{ $sortBy == 'total_orders' ? 'selected' : '' }}>Jumlah Pesanan</option>
							<option value="last_order" {{ $sortBy == 'last_order' ? 'selected' : '' }}>Pesanan Terakhir</option>
						</select>
					</div>

					<!-- Button Container -->
					<div class="flex flex-col justify-end gap-2">
						<button type="submit"
							class="rounded-lg bg-pink-600 px-4 py-2 font-semibold text-white transition hover:bg-pink-700">
							✓ Tampilkan
						</button>
					</div>
				</div>

				<!-- Export Row: CSV dan PDF -->
				<div class="flex flex-col gap-2 border-t border-slate-700 pt-2 sm:flex-row">
					<a
						href="{{ route('best-customer.export', ['period_type' => $periodType, 'top_limit' => $topLimit, 'sort_by' => $sortBy]) }}"
						class="flex items-center justify-center gap-2 rounded-lg bg-green-600 px-4 py-2 font-semibold text-white transition hover:bg-green-700">
						<svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
							stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
						</svg>
						📊 Unduh CSV
					</a>
					<a
						href="{{ route('best-customer.export-pdf', ['period_type' => $periodType, 'top_limit' => $topLimit, 'sort_by' => $sortBy]) }}"
						target="_blank"
						class="flex items-center justify-center gap-2 rounded-lg bg-red-600 px-4 py-2 font-semibold text-white transition hover:bg-red-700">
						<svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
							stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
						</svg>
						📄 Unduh PDF
					</a>
				</div>
			</form>
		</div>

		<!-- Best Customers Table -->
		<div class="rounded-xl bg-slate-800 p-6 shadow-md">
			<h2 class="mb-4 text-xl font-bold text-white">📊 Daftar Pelanggan Terbaik</h2>

			@if ($bestCustomers->count() > 0)
				<div class="overflow-x-auto">
					<table class="w-full text-sm">
						<thead class="border-b border-slate-700 bg-slate-900">
							<tr>
								<th class="px-4 py-3 text-left text-slate-300">🏆 Ranking</th>
								<th class="px-4 py-3 text-left text-slate-300">Nama Pelanggan</th>
								<th class="px-4 py-3 text-center text-slate-300">📋 Total Pesanan</th>
								<th class="px-4 py-3 text-right text-slate-300">💰 Total Pengeluaran</th>
								<th class="px-4 py-3 text-right text-slate-300">📊 Rata-rata</th>
								<th class="px-4 py-3 text-center text-slate-300">🕐 Pesanan Terakhir</th>
								<th class="px-4 py-3 text-center text-slate-300">Aksi</th>
							</tr>
						</thead>
						<tbody class="divide-y divide-slate-700">
							@foreach ($bestCustomers as $customer)
								<tr class="transition hover:bg-slate-700">
									<td class="px-4 py-3">
										@if ($customer->rank == 1)
											<span class="inline-flex h-7 w-7 items-center justify-center rounded-full font-bold text-white"
												style="background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);">🥇</span>
										@elseif($customer->rank == 2)
											<span class="inline-flex h-7 w-7 items-center justify-center rounded-full font-bold text-white"
												style="background: linear-gradient(135deg, #C0C0C0 0%, #A9A9A9 100%);">🥈</span>
										@elseif($customer->rank == 3)
											<span class="inline-flex h-7 w-7 items-center justify-center rounded-full font-bold text-white"
												style="background: linear-gradient(135deg, #CD7F32 0%, #B87333 100%);">🥉</span>
										@else
											<span
												class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-slate-600 font-bold text-white">{{ $customer->rank }}</span>
										@endif
									</td>
									<td class="px-4 py-3 font-semibold text-white">{{ $customer->nama_pelanggan }}</td>
									<td class="px-4 py-3 text-center">
										<span class="inline-flex items-center justify-center rounded-full px-2 py-1 text-xs font-bold"
											style="background: rgba(59, 130, 246, 0.1); color: #60a5fa;">
											{{ $customer->total_orders }} pesanan
										</span>
									</td>
									<td class="px-4 py-3 text-right font-semibold text-green-400">
										Rp {{ number_format($customer->total_spending, 0, ',', '.') }}
									</td>
									<td class="px-4 py-3 text-right text-slate-300">
										Rp {{ number_format($customer->avg_spending, 0, ',', '.') }}
									</td>
									<td class="px-4 py-3 text-center text-slate-300">
										{{ $customer->last_order_date->format('d/m/Y H:i') }}
									</td>
									<td class="px-4 py-3 text-center">
										<a href="{{ route('best-customer.show', ['customerName' => urlencode($customer->nama_pelanggan)]) }}"
											class="inline-flex items-center justify-center rounded-lg px-3 py-1 text-xs font-semibold text-white"
											style="background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);">
											Lihat Detail
										</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>

				<!-- Pagination -->
				<div class="mt-6 flex justify-center">
					{{ $bestCustomers->appends(request()->query())->links() }}
				</div>
			@else
				<div class="py-12 text-center">
					<svg class="mx-auto h-12 w-12 text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none"
						viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
					</svg>
					<p class="mt-4 text-slate-400">Belum ada data pelanggan untuk periode ini</p>
				</div>
			@endif
		</div>
	</div>

	<style>
		/* Custom pagination styling */
		.pagination {
			@apply flex justify-center gap-2;
		}

		.pagination a,
		.pagination span {
			@apply px-3 py-2 rounded-lg;
		}

		.pagination a {
			@apply bg-slate-700 text-white hover:bg-slate-600;
		}

		.pagination .active span {
			@apply bg-pink-600 text-white;
		}

		.pagination .disabled span {
			@apply bg-slate-700 text-slate-500;
		}
	</style>
@endsection
