<!DOCTYPE html>
<html lang="id">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Pembayaran - Kedai Bang Nana</title>
		@vite(['resources/css/app.css', 'resources/js/app.js'])
		<style>
			body {
				background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
			}

			@keyframes pulse-dot {

				0%,
				100% {
					opacity: 0.3;
				}

				50% {
					opacity: 1;
				}
			}

			.pulse-dot {
				display: inline-block;
				animation: pulse-dot 0.6s ease-in-out infinite;
			}

			.pulse-dot:nth-child(2) {
				animation-delay: 0.2s;
			}

			.pulse-dot:nth-child(3) {
				animation-delay: 0.4s;
			}

			@keyframes bounce-up {

				0%,
				100% {
					transform: translateY(0);
				}

				50% {
					transform: translateY(-10px);
				}
			}

			.bounce-card {
				animation: bounce-up 2s ease-in-out infinite;
			}
		</style>
	</head>

	<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
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
			<main class="mx-auto flex w-full max-w-md flex-1 flex-col justify-center px-4 py-8 sm:max-w-2xl sm:py-12">
				<div class="rounded-2xl border-2 p-8 shadow-2xl sm:p-12" style="background: #1e293b; border-color: #334155;">
					<!-- Loading Spinner -->
					<div class="mb-8 flex justify-center">
						<div class="relative h-20 w-20">
							<div class="absolute inset-0 rounded-full border-4 border-slate-200"></div>
							<div class="absolute inset-0 animate-spin rounded-full border-4 border-transparent"
								style="border-top-color: #dc0080; border-right-color: #e91e63;">
							</div>
							<div class="absolute inset-0 flex items-center justify-center text-2xl">💳</div>
						</div>
					</div>

					<!-- Status Text -->
					<h2 class="mb-4 text-center text-2xl font-bold text-white sm:text-3xl">
						Memproses Pembayaran
						<span class="ml-2 inline-block">
							<span class="pulse-dot" style="color: #dc0080;">●</span>
							<span class="pulse-dot" style="color: #dc0080;">●</span>
							<span class="pulse-dot" style="color: #dc0080;">●</span>
						</span>
					</h2>
					<p class="mb-8 text-center text-slate-400">
						Jendela pembayaran akan segera terbuka. Silakan tunggu...
					</p>

					<!-- Order Info Card -->
					<div class="bounce-card mb-8 rounded-xl border-2 p-6 shadow-md"
						style="background: #0f172a; border-color: #dc0080;">
						<div class="mb-4 flex items-center justify-between">
							<span class="text-sm font-semibold uppercase text-slate-400">No. Pesanan</span>
							<span class="text-lg font-bold text-white">{{ $order->no_order }}</span>
						</div>

						<div class="mb-2 text-sm text-slate-400">Total Pembayaran</div>
						<div class="text-3xl font-bold" style="color: #dc0080;">
							Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
						</div>

						<!-- Separator -->
						<div class="my-4 border-t" style="border-color: #334155;"></div>

						<!-- Payment Method -->
						<div class="mb-3 flex items-center justify-between text-sm">
							<span class="text-slate-400">Metode Pembayaran</span>
							<span class="font-semibold text-white">💳 Card / E-Wallet</span>
						</div>

						<!-- Secure Badge -->
						<div class="mt-4 flex items-center justify-center gap-2 rounded-lg p-2" style="background-color: #1e293b;">
							<span class="text-sm font-semibold" style="color: #dc0080;">🔒 Aman & Terenkripsi</span>
						</div>
					</div>

					<!-- Payment Button -->
					<button id="pay-button" onclick="openPaymentModal()"
						class="mb-4 flex w-full items-center justify-center gap-2 rounded-lg px-6 py-4 font-bold text-white shadow-lg transition hover:shadow-xl"
						style="background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);">
						<span class="text-lg">💳</span>
						<span>Buka Jendela Pembayaran</span>
					</button>

					<!-- Help Section -->
					<div class="mt-6 rounded-lg border border-slate-700 bg-slate-900 p-4 text-white">
						<p class="mb-3 text-center text-sm font-semibold text-slate-700">❓ Butuh Bantuan?</p>
						<div class="flex flex-col gap-2 text-center text-xs">
							<a href="tel:6282123456789" class="text-slate-600 transition hover:font-semibold" style="color: #dc0080;">
								📞 Hubungi Kami
							</a>
							<a href="https://wa.me/6282123456789" class="text-slate-600 transition hover:font-semibold"
								style="color: #dc0080;">
								💬 Chat WhatsApp
							</a>
						</div>
					</div>
				</div>
			</main>
		</div>

		<!-- Midtrans Snap Script -->
		<script
			src="https://{{ config('midtrans.is_production') ? 'app.midtrans.com' : 'app.sandbox.midtrans.com' }}/snap/snap.js"
			data-client-key="{{ config('midtrans.client_key') }}"></script>

		<script>
			function openPaymentModal() {
				console.log('Opening payment modal...');
				console.log('Snap token:', '{{ $snapToken ?? '' }}');

				// Check if snap is available
				if (typeof snap === 'undefined') {
					console.error('Midtrans Snap tidak ter-load. Coba refresh halaman.');
					alert('Sistem pembayaran sedang dimuat. Silakan tunggu sebentar...');
					setTimeout(openPaymentModal, 2000);
					return;
				}

				snap.pay('{{ $snapToken }}', {
					onSuccess: function(result) {
						console.log('Payment success:', result);
						window.location.href = "{{ route('order.success', $order->id_order) }}";
					},
					onPending: function(result) {
						console.log('Payment pending:', result);
						window.location.href = "{{ route('order.pending', $order->id_order) }}";
					},
					onError: function(result) {
						console.log('Payment error:', result);
						window.location.href = "{{ route('order.pending', $order->id_order) }}";
					},
					onClose: function() {
						console.log('User closed payment modal');
						window.location.href = "{{ route('menu.public') }}";
					}
				});
			}

			// Auto-open payment modal - Midtrans Snap menampilkan semua metode pembayaran (QRIS, Card, E-Wallet, dll)
			window.addEventListener('load', function() {
				console.log('Page loaded, waiting to open payment...');
				setTimeout(function() {
					console.log('Attempting to open payment modal...');
					openPaymentModal();
				}, 1500);
			});
		</script>
	</body>

</html>
