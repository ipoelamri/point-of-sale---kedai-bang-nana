<!DOCTYPE html>
<html lang="id">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Pembayaran Pending - Kedai Bang Nana</title>
		@vite(['resources/css/app.css', 'resources/js/app.js'])
		<style>
			@keyframes pulse-ring {
				0% {
					box-shadow: 0 0 0 0 rgba(220, 0, 128, 0.7);
				}

				70% {
					box-shadow: 0 0 0 20px rgba(220, 0, 128, 0);
				}

				100% {
					box-shadow: 0 0 0 0 rgba(220, 0, 128, 0);
				}
			}

			.pulse-ring {
				animation: pulse-ring 2s infinite;
			}

			@keyframes slide-in {
				from {
					opacity: 0;
					transform: translateY(20px);
				}

				to {
					opacity: 1;
					transform: translateY(0);
				}
			}

			.slide-in {
				animation: slide-in 0.6s ease-out;
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
			<main class="mx-auto flex w-full max-w-2xl flex-1 flex-col justify-center px-4 py-8 sm:py-12">
				<div class="slide-in rounded-2xl border border-slate-100 bg-white p-8 shadow-2xl sm:p-12">
					<!-- Pending Icon -->
					<div class="mb-8 flex justify-center">
						<div class="relative h-24 w-24">
							<div class="pulse-ring absolute inset-0 rounded-full" style="background-color: #fce7f3;"></div>
							<div class="relative flex h-24 w-24 items-center justify-center rounded-full"
								style="background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);">
								<svg class="h-12 w-12 animate-pulse text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
										d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
								</svg>
							</div>
						</div>
					</div>

					<!-- Status Text -->
					<div class="mb-10 text-center">
						<h2 class="mb-2 text-3xl font-black sm:text-4xl" style="color: #dc0080;">Pembayaran Diproses</h2>
						<p class="text-lg text-slate-600">Mohon tunggu, kami sedang memverifikasi pembayaran Anda</p>
						<p class="mt-2 text-sm text-slate-500">Halaman akan otomatis refresh setiap 10 detik</p>
					</div>

					<!-- Order Info Card -->
					<div class="mb-8 rounded-xl border-2 p-6 sm:p-8"
						style="background: linear-gradient(135deg, #fce7f3 0%, #fce7f3 100%); border-color: #dc0080;">
						<h3 class="mb-6 flex items-center gap-2 text-lg font-bold text-slate-800">
							<span>📋</span> Informasi Pesanan
						</h3>

						<div class="space-y-4">
							<div class="flex items-center justify-between rounded-lg border bg-white p-4" style="border-color: #dc0080;">
								<span class="font-semibold text-slate-600">No. Pesanan</span>
								<span class="text-2xl font-black" style="color: #dc0080;">{{ $order->no_order }}</span>
							</div>

							<div class="flex items-center justify-between rounded-lg border bg-white p-4" style="border-color: #dc0080;">
								<span class="font-semibold text-slate-600">Total Pesanan</span>
								<span class="text-xl font-bold" style="color: #dc0080;">
									Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
								</span>
							</div>

							<div class="flex items-center justify-between rounded-lg border bg-white p-4" style="border-color: #dc0080;">
								<span class="font-semibold text-slate-600">Status Pembayaran</span>
								<span class="inline-block flex items-center gap-1 rounded-full px-4 py-2 text-sm font-bold"
									style="background-color: #fce7f3; color: #dc0080;">
									<span class="h-2 w-2 animate-pulse rounded-full" style="background-color: #dc0080;"></span>
									Menunggu Verifikasi
								</span>
							</div>
						</div>
					</div>

					<!-- Progress Steps -->
					<div class="mb-8 grid grid-cols-3 gap-4">
						<div class="rounded-lg p-4 text-center" style="background-color: #f0fdf4; border: 2px solid #10b981;">
							<div class="mb-2 text-2xl">✓</div>
							<p class="text-sm font-semibold text-slate-800">Pesanan Tercatat</p>
						</div>
						<div class="rounded-lg p-4 text-center" style="background-color: #fce7f3; border: 2px solid #dc0080;">
							<div class="mb-2 animate-pulse text-2xl">⏳</div>
							<p class="text-sm font-semibold text-slate-800">Verifikasi</p>
						</div>
						<div class="rounded-lg p-4 text-center" style="background-color: #f3f4f6; border: 2px solid #d1d5db;">
							<div class="mb-2 text-2xl">🎉</div>
							<p class="text-sm font-semibold text-slate-800">Siap</p>
						</div>
					</div>

					<!-- Info Alert -->
					<div class="mb-8 rounded-lg p-4" style="background-color: #fce7f3; border-left: 4px solid #dc0080;">
						<div class="mb-2 animate-pulse text-2xl">⏳</div>
						<p class="mb-1 text-sm font-semibold" style="color: #c00860;">Verifikasi Pembayaran</p>
						<p class="text-xs" style="color: #d90b84;">Sedang diproses, mohon tunggu...</p>
					</div>

					<!-- Warning Alert -->
					<div class="mb-8 rounded-lg p-4" style="background-color: #fce7f3; border-left: 4px solid #dc0080;">
						<p class="mb-2 text-sm font-semibold" style="color: #c00860;">⚠️ Perhatian:</p>
						<p class="text-xs" style="color: #d90b84;">
							Jangan tutup halaman ini sampai pembayaran selesai diverifikasi. Anda akan diarahkan secara otomatis ke halaman
							konfirmasi.
						</p>
					</div>

					<!-- Action Buttons -->
					<div class="flex flex-col gap-3 sm:flex-row">
						<button onclick="location.reload()"
							class="flex flex-1 items-center justify-center gap-2 rounded-lg px-6 py-3 font-bold text-white shadow-md transition hover:shadow-lg"
							style="background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);">
							<span>🔄</span>
							<span>Refresh Halaman</span>
						</button>
						<a href="{{ route('menu.public') }}"
							class="flex-1 rounded-lg border-2 border-slate-300 px-6 py-3 text-center font-semibold text-slate-700 transition hover:border-slate-400 hover:bg-slate-100">
							← Kembali ke Menu
						</a>
					</div>

					<!-- Help Section -->
					<div class="mt-6 rounded-lg border border-slate-700 bg-slate-900 p-4 text-center text-white sm:p-6">
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
							<a href="mailto:support@kejai-bang-nana.com"
								class="flex items-center justify-center gap-1 font-semibold transition" style="color: #dc0080;">
								📧 Email Support
							</a>
						</div>
					</div>
				</div>
			</main>
		</div>

		<script>
			// Auto refresh every 10 seconds
			setTimeout(() => {
				location.reload();
			}, 10000);
		</script>
	</body>

</html>
