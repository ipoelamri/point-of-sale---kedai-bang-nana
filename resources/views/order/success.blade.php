<!DOCTYPE html>
<html lang="id">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Pembayaran Berhasil - Kedai Bang Nana</title>
		@vite(['resources/css/app.css', 'resources/js/app.js'])
		<style>
			body {
				background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
			}

			@keyframes checkmark-bounce {

				0%,
				100% {
					transform: scale(1);
				}

				50% {
					transform: scale(1.1);
				}
			}

			.checkmark-bounce {
				animation: checkmark-bounce 0.6s ease-in-out 2;
			}

			@keyframes slideDown {
				from {
					opacity: 0;
					transform: translateY(-20px);
				}

				to {
					opacity: 1;
					transform: translateY(0);
				}
			}

			.slide-down {
				animation: slideDown 0.6s ease-out;
			}

			@media (max-width: 640px) {
				.receipt-card {
					font-size: 0.875rem;
				}
			}
		</style>
	</head>

	<body class="bg-gradient-to-br from-emerald-50 to-slate-50">
		<div class="flex min-h-screen flex-col">
			<!-- Header -->
			<header class="sticky top-0 z-50 shadow-lg" style="background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);">
				<div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4">
					<div class="flex items-center gap-3">
						<img src="{{ asset('images/logo.png') }}" alt="Logo Kedai Bang Nana" class="h-10 w-10 object-contain">
						<div>
							<h1 class="text-2xl font-bold text-white">Kedai Bang Nana</h1>
							<p class="text-sm text-white opacity-90">Café & Resto</p>
						</div>
					</div>
				</div>
			</header>

			<!-- Main Content -->
			<main class="mx-auto flex w-full max-w-2xl flex-1 flex-col justify-center px-4 py-6 sm:py-12">
				<div class="slide-down rounded-2xl border border-emerald-100 bg-white p-8 shadow-2xl sm:p-12">
					<!-- Success Icon -->
					<div class="mb-8 flex justify-center">
						<div class="relative">
							<div class="absolute inset-0 animate-pulse rounded-full bg-emerald-100"></div>
							<div class="checkmark-bounce relative flex h-24 w-24 items-center justify-center rounded-full"
								style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
								<svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
								</svg>
							</div>
						</div>
					</div>

					<!-- Success Message -->
					<div class="slide-down mb-10 text-center" style="animation-delay: 0.1s;">
						<h2 class="mb-2 text-3xl font-black text-emerald-600 sm:text-4xl">Pesanan Berhasil!</h2>
						<p class="text-slate-600">Terima kasih telah memesan di Kedai Bang Nana</p>
						<p class="mt-2 text-sm text-slate-500">Pesanan Anda sedang disiapkan oleh dapur kami</p>
					</div>

					<!-- Receipt Card -->
					<div class="receipt-card slide-down mb-8 rounded-xl border-2 p-6 sm:p-8"
						style="animation-delay: 0.2s; background: linear-gradient(135deg, #f0fdf4 0%, #f0fdf4 100%); border-color: #10b981;">
						<h3 class="mb-6 flex items-center justify-center gap-2 text-center text-lg font-bold text-slate-800 sm:text-xl">
							<span>🧾</span> Bukti Pesanan
						</h3>

						<!-- Order Header -->
						<div class="mb-6 space-y-3 pb-6" style="border-bottom: 2px solid #10b981;">
							<div class="flex items-center justify-between">
								<span class="font-semibold text-slate-600">📋 No. Pesanan</span>
								<span class="text-xl font-black" style="color: #10b981;">{{ $order->no_order }}</span>
							</div>

							<div class="flex items-center justify-between">
								<span class="font-semibold text-slate-600">👤 Nama</span>
								<span class="font-semibold text-slate-800">{{ $order->nama_pelanggan }}</span>
							</div>

							<div class="flex items-center justify-between">
								<span class="font-semibold text-slate-600">📍 Tipe Pesanan</span>
								<span class="inline-block rounded-full px-3 py-1 text-sm font-semibold"
									style="background-color: #dbeafe; color: #10b981;">
									@if ($order->tipe_pesanan == 'dine-in')
										🪑 Makan di Tempat
										@if ($order->no_meja)
											(Meja {{ $order->no_meja }})
										@endif
									@else
										🛍️ Bawa Pulang
									@endif
								</span>
							</div>

							<div class="flex items-center justify-between">
								<span class="font-semibold text-slate-600">💳 Metode Pembayaran</span>
								<span
									class="font-semibold text-slate-800">{{ ucfirst(str_replace('_', ' ', $pembayaran->metode_bayar)) }}</span>
							</div>

							<div class="flex items-center justify-between">
								<span class="font-semibold text-slate-600">⏰ Waktu Bayar</span>
								<span class="font-semibold text-slate-800">{{ $pembayaran->waktu_bayar->format('d/m/Y H:i') }}</span>
							</div>
						</div>

						<!-- Order Items -->
						<div class="mb-6 pb-6" style="border-bottom: 2px solid #10b981;">
							<h4 class="mb-4 flex items-center gap-2 font-bold text-slate-800">
								<span>🍽️</span> Item Pesanan:
							</h4>
							<div class="space-y-3">
								@php
									$items = $order->orderItems;
								@endphp
								@foreach ($items as $item)
									<div class="flex items-center justify-between rounded-lg bg-white p-3">
										<div>
											<p class="font-semibold text-slate-800">{{ $item->menu->nama_menu }}</p>
											<p class="text-xs text-slate-600">{{ $item->jumlah }} x Rp
												{{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
										</div>
										<p class="text-right font-bold" style="color: #10b981;">
											Rp {{ number_format($item->subtotal, 0, ',', '.') }}
										</p>
									</div>
								@endforeach
							</div>
						</div>

						<!-- Total -->
						<div class="mb-6 flex items-center justify-between rounded-lg p-4 text-white"
							style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
							<span class="text-lg font-bold">💰 Total Bayar</span>
							<span class="text-3xl font-black">
								Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
							</span>
						</div>

						<!-- Status Badge -->
						<div class="flex items-center justify-center gap-2 rounded-lg border-2 p-3"
							style="background-color: #dbeafe; border-color: #10b981;">
							<span class="text-lg">✓</span>
							<p class="font-semibold" style="color: #10b981;">Status: Pembayaran Dikonfirmasi</p>
						</div>
					</div>

					<!-- Info Boxes -->
					<div class="slide-down mb-8 grid grid-cols-1 gap-4 sm:grid-cols-3" style="animation-delay: 0.3s;">
						<div class="rounded-lg border-l-4 border-blue-500 bg-blue-50 p-4 text-center">
							<div class="mb-2 text-3xl">👨‍🍳</div>
							<p class="text-sm font-semibold text-blue-900">Sedang Diproses</p>
							<p class="mt-1 text-xs text-blue-700">Dapur sedang mempersiapkan</p>
						</div>
						<div class="rounded-lg border-l-4 border-amber-500 bg-amber-50 p-4 text-center">
							<div class="mb-2 text-3xl">⏱️</div>
							<p class="text-sm font-semibold text-amber-900">15-30 Menit</p>
							<p class="mt-1 text-xs text-amber-700">Estimasi waktu siap</p>
						</div>
						<div class="rounded-lg border-l-4 border-green-500 bg-green-50 p-4 text-center">
							<div class="mb-2 text-3xl">📱</div>
							<p class="text-sm font-semibold text-green-900">Nomor Pesanan</p>
							<p class="mt-1 text-xs text-green-700">Tunjukkan saat ambil</p>
						</div>
					</div>

					<!-- Actions -->
					<div class="slide-down mb-8 flex flex-col gap-3 sm:flex-row" style="animation-delay: 0.4s;">
						<a href="{{ route('menu.public') }}"
							class="flex flex-1 items-center justify-center gap-2 rounded-lg px-6 py-3 text-center font-bold text-white shadow-md transition hover:shadow-lg"
							style="background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);">
							<span>➕</span>
							<span>Pesan Lagi</span>
						</a>
						<button onclick="window.print()"
							class="flex flex-1 items-center justify-center gap-2 rounded-lg border-2 border-slate-600 px-6 py-3 text-center font-bold text-white transition hover:border-slate-500 hover:bg-slate-800">
							<span>🖨️</span>
							<span>Print Bukti</span>
						</button>
					</div>

					<!-- Help Section -->
					<div class="slide-down rounded-lg border border-slate-700 bg-slate-900 p-4 text-center text-white sm:p-6"
						style="animation-delay: 0.5s;">
						<p class="mb-3 text-sm font-semibold text-slate-600">
							❓ Butuh bantuan?
						</p>
						<div class="flex flex-col justify-center gap-3 text-sm sm:flex-row">
							<a href="tel:+6281234567890" class="flex items-center justify-center gap-1 font-semibold transition"
								style="color: #dc0080;">
								☎️ +62 812 3456 7890
							</a>
							<a href="https://wa.me/6281234567890" target="_blank"
								class="flex items-center justify-center gap-1 font-semibold text-green-600 hover:text-green-700">
								💬 WhatsApp Support
							</a>
						</div>
					</div>
				</div>
			</main>

			<!-- Footer -->
			<footer class="mt-12 bg-slate-800 py-6 text-center text-sm text-slate-400">
				<p>&copy; 2026 Kedai Bang Nana. Semua hak cipta dilindungi. | Dibuat dengan ❤️</p>
			</footer>
		</div>
	</body>

</html>
