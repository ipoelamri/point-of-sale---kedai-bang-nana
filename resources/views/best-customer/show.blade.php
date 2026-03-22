@extends('layouts.app')

@section('title', 'Detail Pelanggan - ' . $customerName)

@section('content')
	<div class="space-y-6">
		<!-- Header dengan Back Button -->
		<div class="flex items-center justify-between">
			<div class="flex-1 rounded-lg px-6 py-4 text-white"
				style="background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);">
				<div class="flex items-center gap-4">
					<a href="{{ route('best-customer.index') }}" class="transition hover:text-pink-100">
						<svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
						</svg>
					</a>
					<div>
						<h1 class="text-3xl font-bold">{{ $customerName }}</h1>
						<p class="mt-1 text-pink-100">Detail Riwayat Pembelian dan Analisis</p>
					</div>
				</div>
			</div>
		</div>

		<!-- Customer Statistics Cards -->
		<div class="grid grid-cols-1 gap-4 md:grid-cols-5">
			<!-- Total Orders Card -->
			<div class="rounded-xl bg-slate-800 p-6 shadow-md">
				<div class="flex items-center justify-between">
					<div>
						<p class="text-sm text-slate-400">Total Pesanan</p>
						<p class="text-2xl font-bold text-white">{{ $customerStats->total_orders ?? 0 }}</p>
					</div>
					<div class="rounded-full p-3" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
						<svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
							stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
						</svg>
					</div>
				</div>
			</div>

			<!-- Total Spending Card -->
			<div class="rounded-xl bg-slate-800 p-6 shadow-md">
				<div class="flex items-center justify-between">
					<div>
						<p class="text-sm text-slate-400">Total Pengeluaran</p>
						<p class="text-xl font-bold text-green-400">Rp
							{{ number_format($customerStats->total_spending ?? 0, 0, ',', '.') }}</p>
					</div>
					<div class="rounded-full p-3" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
						<svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
							stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01M12 12v-.01" />
						</svg>
					</div>
				</div>
			</div>

			<!-- Average Spending Card -->
			<div class="rounded-xl bg-slate-800 p-6 shadow-md">
				<div class="flex items-center justify-between">
					<div>
						<p class="text-sm text-slate-400">Rata-rata Pesanan</p>
						<p class="text-xl font-bold text-yellow-400">Rp {{ number_format($customerStats->avg_spending ?? 0, 0, ',', '.') }}
						</p>
					</div>
					<div class="rounded-full p-3" style="background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);">
						<svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
							stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
						</svg>
					</div>
				</div>
			</div>

			<!-- First Order Date -->
			<div class="rounded-xl bg-slate-800 p-6 shadow-md">
				<div class="flex items-center justify-between">
					<div>
						<p class="text-sm text-slate-400">Pesanan Pertama</p>
						<p class="text-sm font-bold text-white">{{ $customerStats->first_order_date->format('d/m/Y') }}</p>
						<p class="text-xs text-slate-500">{{ $customerStats->first_order_date->diffForHumans() }}</p>
					</div>
					<div class="rounded-full p-3" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);">
						<svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
							stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M8 7V3m8 4V3m-9 8h18M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
						</svg>
					</div>
				</div>
			</div>

			<!-- Last Order Date -->
			<div class="rounded-xl bg-slate-800 p-6 shadow-md">
				<div class="flex items-center justify-between">
					<div>
						<p class="text-sm text-slate-400">Pesanan Terakhir</p>
						<p class="text-sm font-bold text-white">{{ $customerStats->last_order_date->format('d/m/Y') }}</p>
						<p class="text-xs text-slate-500">{{ $customerStats->last_order_date->diffForHumans() }}</p>
					</div>
					<div class="rounded-full p-3" style="background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);">
						<svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
							stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
								d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
						</svg>
					</div>
				</div>
			</div>
		</div>

		<!-- Filter Periode -->
		<div class="rounded-xl bg-slate-800 p-6 shadow-md">
			<form method="GET" class="flex items-center gap-4">
				<label for="period" class="text-sm font-semibold text-slate-300">Periode:</label>
				<select name="period" id="period"
					class="rounded-lg border border-slate-600 bg-slate-700 px-3 py-2 text-white focus:border-pink-500 focus:outline-none">
					<option value="7" {{ $period == 7 ? 'selected' : '' }}>7 Hari Terakhir</option>
					<option value="30" {{ $period == 30 ? 'selected' : '' }}>30 Hari Terakhir</option>
					<option value="60" {{ $period == 60 ? 'selected' : '' }}>60 Hari Terakhir</option>
					<option value="90" {{ $period == 90 ? 'selected' : '' }}>90 Hari Terakhir</option>
					<option value="365" {{ $period == 365 ? 'selected' : '' }}>1 Tahun Terakhir</option>
				</select>
				<button type="submit" class="rounded-lg bg-pink-600 px-4 py-2 font-semibold text-white hover:bg-pink-700">
					Filter
				</button>
			</form>
		</div>

		<!-- Order History Table -->
		<div class="rounded-xl bg-slate-800 p-6 shadow-md">
			<h2 class="mb-4 text-xl font-bold text-white">📋 Riwayat Pesanan</h2>

			@if ($customerOrders->count() > 0)
				<div class="overflow-x-auto">
					<table class="w-full text-sm">
						<thead class="border-b border-slate-700 bg-slate-900">
							<tr>
								<th class="px-4 py-3 text-left text-slate-300">No. Pesanan</th>
								<th class="px-4 py-3 text-left text-slate-300">Tanggal</th>
								<th class="px-4 py-3 text-left text-slate-300">Tipe Pesanan</th>
								<th class="px-4 py-3 text-center text-slate-300">Jumlah Item</th>
								<th class="px-4 py-3 text-right text-slate-300">Total</th>
								<th class="px-4 py-3 text-left text-slate-300">Metode Pembayaran</th>
								<th class="px-4 py-3 text-center text-slate-300">Status Pembayaran</th>
								<th class="px-4 py-3 text-center text-slate-300">Aksi</th>
							</tr>
						</thead>
						<tbody class="divide-y divide-slate-700">
							@foreach ($customerOrders as $order)
								<tr class="transition hover:bg-slate-700">
									<td class="px-4 py-3 font-semibold text-white">{{ $order->no_order }}</td>
									<td class="px-4 py-3 text-slate-300">
										<div class="text-sm">{{ $order->created_at->format('d/m/Y') }}</div>
										<div class="text-xs text-slate-500">{{ $order->created_at->format('H:i') }}</div>
									</td>
									<td class="px-4 py-3 text-slate-300">
										<span
											class="inline-flex items-center justify-center rounded-full bg-slate-700 px-2 py-1 text-xs font-bold text-slate-200">
											{{ ucfirst(str_replace('_', ' ', $order->tipe_pesanan)) }}
										</span>
									</td>
									<td class="px-4 py-3 text-center text-slate-300">
										{{ $order->orderItems->count() }} item
									</td>
									<td class="px-4 py-3 text-right font-semibold text-green-400">
										Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
									</td>
									<td class="px-4 py-3 text-slate-300">
										@if ($order->pembayaran)
											<span class="inline-flex items-center justify-center rounded-full px-2 py-1 text-xs font-bold"
												style="background: rgba(168, 85, 247, 0.1); color: #d8b4fe;">
												{{ ucfirst($order->pembayaran->metode_pembayaran) }}
											</span>
										@else
											<span class="text-slate-500">-</span>
										@endif
									</td>
									<td class="px-4 py-3 text-center">
										@if ($order->pembayaran)
											@if ($order->pembayaran->status_pembayaran === 'lunas')
												<span class="inline-flex items-center justify-center rounded-full px-2 py-1 text-xs font-bold"
													style="background: rgba(16, 185, 129, 0.1); color: #6ee7b7;">
													✓ Lunas
												</span>
											@elseif($order->pembayaran->status_pembayaran === 'pending')
												<span class="inline-flex items-center justify-center rounded-full px-2 py-1 text-xs font-bold"
													style="background: rgba(251, 191, 36, 0.1); color: #fcd34d;">
													⏳ Pending
												</span>
											@else
												<span class="inline-flex items-center justify-center rounded-full px-2 py-1 text-xs font-bold"
													style="background: rgba(239, 68, 68, 0.1); color: #fca5a5;">
													✗ Gagal
												</span>
											@endif
										@else
											<span class="text-slate-500">-</span>
										@endif
									</td>
									<td class="px-4 py-3 text-center">
										<a href="{{ route('order.show', $order->id_order) }}" class="text-blue-400 hover:text-blue-300">
											<svg class="inline h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
												stroke="currentColor">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
													d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
											</svg>
										</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>

				<!-- Pagination -->
				<div class="mt-6 flex justify-center">
					{{ $customerOrders->appends(request()->query())->links() }}
				</div>
			@else
				<div class="py-12 text-center">
					<svg class="mx-auto h-12 w-12 text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none"
						viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
							d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
					</svg>
					<p class="mt-4 text-slate-400">Belum ada pesanan untuk periode ini</p>
				</div>
			@endif
		</div>
	</div>

	<style>
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
