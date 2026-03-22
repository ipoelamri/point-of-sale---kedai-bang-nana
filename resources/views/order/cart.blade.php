<!DOCTYPE html>
<html lang="id">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Keranjang - Kedai Bang Nana</title>
		@vite(['resources/css/app.css', 'resources/js/app.js'])
		<style>
			@media (max-width: 768px) {
				.cart-item {
					display: flex;
					flex-direction: column;
					gap: 1rem;
					padding: 1rem;
					border-bottom: 1px solid #e2e8f0;
				}

				.cart-item-row {
					display: flex;
					justify-content: space-between;
					align-items: center;
				}
			}
		</style>
	</head>

	<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
		<div class="flex min-h-screen flex-col">
			<!-- Header -->
			<header class="sticky top-0 z-50 shadow-md" style="background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);">
				<div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4">
					<div class="flex items-center gap-3">
						<img src="{{ asset('images/logo.png') }}" alt="Logo Kedai Bang Nana" class="h-10 w-10 object-contain">
						<div>
							<h1 class="text-2xl font-bold text-white">Kedai Bang Nana</h1>
							<p class="text-sm text-white opacity-90">Café & Resto</p>
						</div>
					</div>
					<a href="{{ route('menu.public') }}" class="font-medium text-white opacity-90 transition hover:text-white">
						← Kembali ke Menu
					</a>
				</div>
			</header>

			<!-- Main Content -->
			<main class="mx-auto w-full max-w-4xl flex-1 px-4 py-6 sm:py-8">
				<div class="mb-8">
					<h2 class="text-2xl font-bold text-white sm:text-3xl">🛒 Keranjang Belanja</h2>
					<p class="mt-1 text-sm text-slate-400">Periksa pesanan Anda sebelum checkout</p>
				</div>

				@if (session('success'))
					<div
						class="animate-fade-in mb-6 flex items-center justify-between rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-emerald-800">
						<span>✓ {{ session('success') }}</span>
						<button onclick="this.parentElement.style.display='none'" class="text-emerald-600 hover:text-emerald-800">
							✕
						</button>
					</div>
				@endif

				@if (count($cart) > 0)
					<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
						<!-- Cart Items -->
						<div class="lg:col-span-2">
							<!-- Desktop View -->
							<div class="hidden overflow-hidden rounded-xl shadow-lg sm:block"
								style="background: #1e293b; border: 1px solid #334155;">
								<div class="overflow-x-auto">
									<table class="w-full">
										<thead style="background: #0f172a; border-bottom: 2px solid #334155;">
											<tr>
												<th class="px-6 py-4 text-left text-sm font-bold text-white">Menu</th>
												<th class="px-6 py-4 text-right text-sm font-bold text-white">Harga</th>
												<th class="px-6 py-4 text-center text-sm font-bold text-white">Jumlah</th>
												<th class="px-6 py-4 text-right text-sm font-bold text-white">Subtotal</th>
												<th class="px-6 py-4 text-center text-sm font-bold text-white">Aksi</th>
											</tr>
										</thead>
										<tbody>
											@php $grandTotal = 0; @endphp
											@foreach ($cart as $menuId => $item)
												@php
													$subtotal = $item['harga'] * $item['quantity'];
													$grandTotal += $subtotal;
												@endphp
												<tr style="background: #1e293b; border-bottom: 1px solid #334155;"
													class="transition hover:bg-slate-800 hover:shadow-md">
													<td class="px-6 py-4">
														<div class="flex gap-3">
															<img src="{{ asset('storage/' . $item['foto']) }}" alt="{{ $item['nama_menu'] }}"
																class="h-16 w-16 rounded-lg border border-slate-600 object-cover shadow-sm">
															<div>
																<p class="font-semibold text-white">{{ $item['nama_menu'] }}</p>
																<p class="mt-1 text-xs text-slate-400">Kategori: Menu</p>
															</div>
														</div>
													</td>
													<td class="px-6 py-4 text-right text-sm font-medium text-slate-300">
														Rp {{ number_format($item['harga'], 0, ',', '.') }}
													</td>
													<td class="px-6 py-4 text-center">
														<span
															class="inline-block rounded-lg bg-slate-700 px-3 py-1 font-bold text-white">{{ $item['quantity'] }}</span>
													</td>
													<td class="px-6 py-4 text-right font-bold" style="color: #dc0080;">
														Rp {{ number_format($subtotal, 0, ',', '.') }}
													</td>
													<td class="px-6 py-4 text-center">
														<form action="{{ route('cart.remove', $menuId) }}" method="POST" style="display:inline;">
															@csrf
															@method('DELETE')
															<button type="submit"
																class="rounded-lg bg-rose-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-rose-700">
																🗑 Hapus
															</button>
														</form>
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
								</div>
							</div>

							<!-- Mobile View -->
							<div class="space-y-3 sm:hidden">
								@php $grandTotal = 0; @endphp
								@foreach ($cart as $menuId => $item)
									@php
										$subtotal = $item['harga'] * $item['quantity'];
										$grandTotal += $subtotal;
									@endphp
									<div class="rounded-lg p-4 shadow-md" style="background: #1e293b; border: 1px solid #334155;">
										<!-- Image & Info -->
										<div class="mb-4 flex gap-3">
											<img src="{{ asset('storage/' . $item['foto']) }}" alt="{{ $item['nama_menu'] }}"
												class="h-20 w-20 flex-shrink-0 rounded-lg border border-slate-600 object-cover">
											<div class="flex-1">
												<p class="text-base font-bold text-white">{{ $item['nama_menu'] }}</p>
												<p class="mt-1 text-sm text-slate-400">Rp {{ number_format($item['harga'], 0, ',', '.') }}/item</p>
											</div>
										</div>
										<!-- Quantity & Price -->
										<div class="flex items-center justify-between border-t border-slate-700 pt-3">
											<div>
												<p class="mb-1 text-xs text-slate-400">Kuantitas</p>
												<span
													class="inline-block rounded-lg bg-slate-700 px-3 py-1 text-sm font-bold text-white">{{ $item['quantity'] }}</span>
											</div>
											<div class="text-right">
												<p class="mb-1 text-xs text-slate-400">Subtotal</p>
												<p class="text-lg font-bold" style="color: #dc0080;">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
											</div>
											<form action="{{ route('cart.remove', $menuId) }}" method="POST" style="display:inline;">
												@csrf
												@method('DELETE')
												<button type="submit"
													class="rounded-lg bg-rose-600 px-3 py-2 text-sm font-medium text-white transition hover:bg-rose-700">
													Hapus
												</button>
											</form>
										</div>
									</div>
								@endforeach
							</div>
						</div>

						<!-- Summary Card -->
						<div class="lg:col-span-1">
							<div class="sticky top-24 rounded-lg p-6 shadow-lg" style="background: #1e293b; border: 2px solid #dc0080;">
								<h3 class="mb-6 text-xl font-bold text-white">📋 Ringkasan Pesanan</h3>

								<!-- Breakdown -->
								<div class="mb-6 space-y-3 pb-6" style="border-bottom: 1px solid #334155;">
									<div class="flex justify-between text-sm">
										<span class="text-slate-400">Subtotal:</span>
										<span class="font-semibold text-white">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
									</div>
									@php $ppn = $grandTotal * 0.1; @endphp
									<div class="flex justify-between text-sm">
										<span class="text-slate-400">PPN 10%:</span>
										<span class="font-semibold text-white">Rp {{ number_format($ppn, 0, ',', '.') }}</span>
									</div>
								</div>

								<!-- Total -->
								<div class="mb-6">
									<div class="flex items-baseline justify-between">
										<span class="text-base font-bold text-slate-300">Total Bayar:</span>
										<span class="text-3xl font-bold" style="color: #dc0080;">
											Rp {{ number_format($total, 0, ',', '.') }}
										</span>
									</div>
								</div>

								<!-- Buttons -->
								<div class="space-y-3">
									<a href="{{ route('menu.public') }}"
										class="block w-full rounded-lg border-2 border-slate-600 bg-slate-900 px-4 py-3 text-center font-bold text-white transition hover:border-slate-500 hover:bg-slate-800">
										← Lanjut Belanja
									</a>
									<a href="{{ route('order.checkout') }}"
										class="block w-full rounded-lg px-4 py-3 text-center font-bold text-white shadow-md transition hover:shadow-lg"
										style="background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);">
										✓ Lanjut ke Pembayaran →
									</a>
								</div>

								<!-- Info -->
								<div class="mt-6 space-y-2 text-center text-xs text-slate-400">
									<p>✓ Pembayaran Aman & Terenkripsi</p>
									<p>✓ Proses Cepat & Mudah</p>
								</div>
							</div>
						</div>
					</div>
				@else
					<div class="rounded-xl border border-slate-200 bg-white p-8 text-center shadow-sm sm:p-12">
						<div class="mb-4 text-5xl">🛒</div>
						<p class="mb-6 text-lg text-slate-600">Keranjang Anda kosong</p>
						<p class="mb-8 text-sm text-slate-500">Mulai pilih menu favorit Anda untuk memulai pesanan</p>
						<a href="{{ route('menu.public') }}"
							class="inline-block rounded-lg bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-3 font-semibold text-white shadow-md transition hover:from-amber-600 hover:to-amber-700 hover:shadow-lg">
							← Kembali ke Menu
						</a>
					</div>
				@endif
			</main>

			<!-- Footer -->
			<footer class="mt-12 bg-slate-800 py-6 text-center text-sm text-slate-400">
				<p>&copy; 2026 Kedai Bang Nana. Semua hak cipta dilindungi. | Dibuat dengan ❤️</p>
			</footer>
		</div>
	</body>

</html>
