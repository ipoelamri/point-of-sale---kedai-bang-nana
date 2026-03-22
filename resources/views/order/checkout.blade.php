<!DOCTYPE html>
<html lang="id">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Checkout - Kedai Bang Nana</title>
		@vite(['resources/css/app.css', 'resources/js/app.js'])
		<style>
			@keyframes slideInUp {
				from {
					opacity: 0;
					transform: translateY(30px);
				}

				to {
					opacity: 1;
					transform: translateY(0);
				}
			}

			.form-animate {
				animation: slideInUp 0.6s ease-out;
			}

			.form-field:focus-within label {
				color: #dc0080;
				font-weight: 600;
			}

			@media (max-width: 768px) {
				.summary-sticky {
					position: relative;
					top: 0;
				}
			}
		</style>
	</head>

	<body class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900">
		<div class="flex min-h-screen flex-col">
			<!-- Header -->
			<header class="sticky top-0 z-50 shadow-md" style="background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);">
				<div class="mx-auto max-w-7xl px-4 py-4">
					<div class="flex items-center justify-between gap-4">
						<div class="flex items-center gap-3">
							<img src="{{ asset('images/logo.png') }}" alt="Logo Kedai Bang Nana" class="h-12 w-12 object-contain">
							<div>
								<h1 class="text-2xl font-bold text-white">Kedai Bang Nana</h1>
								<p class="text-sm text-white opacity-90">Café & Resto</p>
							</div>
						</div>
						<a href="{{ route('cart.view') }}" class="font-medium text-white opacity-90 transition hover:text-white">
							← Kembali ke Keranjang
						</a>
					</div>
				</div>
			</header>

			<!-- Progress Bar -->
			<div class="border-b border-slate-700 bg-slate-800 shadow-sm">
				<div class="mx-auto max-w-7xl px-4 py-6">
					<div class="flex items-center justify-between">
						<div class="flex flex-col items-center gap-1 sm:gap-2">
							<div class="flex h-8 w-8 items-center justify-center rounded-full text-sm font-bold text-white"
								style="background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);">
								1</div>
							<span class="text-xs font-semibold sm:text-sm" style="color: #dc0080;">Cart</span>
						</div>
						<div class="h-1 flex-1" style="background: linear-gradient(90deg, #dc0080 0%, #d90b84 100%);"></div>
						<div class="flex flex-col items-center gap-1 sm:gap-2">
							<div class="flex h-8 w-8 items-center justify-center rounded-full text-sm font-bold text-white"
								style="background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);">
								2</div>
							<span class="text-xs font-semibold sm:text-sm" style="color: #dc0080;">Checkout</span>
						</div>
						<div class="h-1 flex-1 bg-slate-200"></div>
						<div class="flex flex-col items-center gap-1 sm:gap-2">
							<div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-300 text-sm font-bold text-white">3
							</div>
							<span class="text-xs text-slate-600 sm:text-sm">Payment</span>
						</div>
					</div>
				</div>
			</div>

			<!-- Main Content -->
			<main class="mx-auto w-full max-w-7xl flex-1 px-4 py-6 sm:py-8">
				<div class="mb-8">
					<h2 class="text-2xl font-bold text-white sm:text-3xl">📝 Checkout Pesanan</h2>
					<p class="mt-1 text-sm text-slate-400">Lengkapi informasi pesanan Anda</p>
				</div>

				<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
					<!-- Form Checkout -->
					<div class="form-animate rounded-xl border border-slate-700 bg-slate-900 p-6 shadow-lg sm:p-8 lg:col-span-2">
						<h3 class="mb-8 flex items-center gap-2 text-xl font-bold text-white sm:text-2xl">
							<span class="text-2xl">🛎️</span> Informasi Pesanan
						</h3>

						@if ($errors->any())
							<div class="mb-6 rounded-lg border-l-4 border-rose-500 bg-rose-950 p-4 shadow-sm">
								<h4 class="mb-2 flex items-center gap-2 font-semibold text-rose-300">
									<span>⚠️</span> Perbaiki Error:
								</h4>
								<ul class="space-y-1 text-sm text-rose-400">
									@foreach ($errors->all() as $error)
										<li>• {{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif

						<form action="{{ route('order.checkout') }}" method="POST" class="space-y-6">
							@csrf

							<!-- Nama Pemesan -->
							<div class="form-field space-y-2">
								<label class="block font-semibold text-white transition" for="nama_pemesan">
									👤 Nama Pemesan
								</label>
								<input id="nama_pemesan" type="text" name="nama_pemesan" value="{{ old('nama_pemesan') }}"
									class="w-full rounded-lg border-2 border-slate-600 bg-slate-800 px-4 py-3 text-white shadow-sm transition focus:border-pink-400 focus:outline-none"
									placeholder="Masukkan nama Anda" required>
								@error('nama_pemesan')
									<p class="text-sm text-rose-400">{{ $message }}</p>
								@enderror
							</div>

							<!-- Tipe Pesanan -->
							<div class="space-y-3">
								<label class="block font-semibold text-white">🏠 Tipe Pesanan</label>
								<div class="space-y-2">
									@foreach (['Dine In' => 'Makan di Tempat', 'Take Away' => 'Bawa Pulang'] as $value => $label)
										<label
											class="flex cursor-pointer items-center gap-4 rounded-lg border-2 border-slate-700 bg-slate-800 p-4 transition hover:border-pink-500"
											style="hover-bg-color: #1e293b;">
											<input type="radio" name="tipe_pesanan" value="{{ $value }}"
												{{ old('tipe_pesanan') == $value ? 'checked' : '' }} class="h-5 w-5" onchange="updateBorderAndBg(this)">
											<div>
												<p class="font-semibold text-white">{{ $label }}</p>
												<p class="text-sm text-slate-400">
													{{ $value === 'Dine In' ? 'Pesan untuk dimakan di restoran' : 'Pesan untuk dibawa pulang' }}
												</p>
											</div>
											<div class="checked-visible ml-auto hidden h-3 w-3 rounded-full" style="background-color: #dc0080;"></div>
										</label>
									@endforeach
								</div>
								@error('tipe_pesanan')
									<p class="text-sm text-rose-400">{{ $message }}</p>
								@enderror
							</div>

							<!-- Nomor Meja -->
							<div class="form-field space-y-2">
								<label class="block font-semibold text-white transition" for="no_meja">
									🎫 Nomor Meja <span class="text-slate-400">(Untuk Dine In)</span>
								</label>
								<input id="no_meja" type="text" name="no_meja" value="{{ old('no_meja') }}"
									class="w-full rounded-lg border-2 border-slate-600 bg-slate-800 px-4 py-3 text-white shadow-sm transition focus:border-pink-400 focus:outline-none"
									placeholder="Masukkan nomor meja">
								@error('no_meja')
									<p class="text-sm text-rose-400">{{ $message }}</p>
								@enderror
							</div>

							<!-- Tombol Submit -->
							<div class="flex flex-col gap-3 pt-6 sm:flex-row">
								<a href="{{ route('cart.view') }}"
									class="flex-1 rounded-lg border-2 border-slate-600 bg-slate-800 px-6 py-3 text-center font-semibold text-white transition hover:border-slate-500 hover:bg-slate-700">
									← Kembali
								</a>
								<button type="submit"
									class="flex-1 rounded-lg px-6 py-3 font-bold text-white shadow-md transition hover:shadow-lg"
									style="background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);">
									✓ Lanjut ke Pembayaran
								</button>
							</div>
						</form>
					</div>

					<!-- Summary Card -->
					<div class="summary-sticky lg:sticky lg:top-24 lg:h-fit">
						<div class="rounded-xl border-2 border-slate-700 bg-slate-800 p-6 shadow-lg">
							<h3 class="mb-6 flex items-center gap-2 text-lg font-bold text-white">
								<span>📋</span> Ringkasan Pesanan
							</h3>

							<div class="mb-6 space-y-3 pb-6" style="border-bottom: 1px solid #475569;">
								@php $grandTotal = 0; @endphp
								@foreach ($cart as $menuId => $item)
									@php
										$subtotal = $item['harga'] * $item['quantity'];
										$grandTotal += $subtotal;
									@endphp
									<div class="flex justify-between text-sm">
										<span class="text-slate-300">{{ $item['quantity'] }}x {{ $item['nama_menu'] }}</span>
										<span class="font-semibold text-white">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
									</div>
								@endforeach
							</div>

							<div class="mb-6 flex items-baseline justify-between">
								<span class="text-lg font-bold text-slate-800">Total:</span>
								<span class="text-3xl font-bold" style="color: #dc0080;">
									Rp {{ number_format($total, 0, ',', '.') }}
								</span>
							</div>

							<div class="rounded-lg p-4 text-center" style="background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);">
								<p class="text-sm font-semibold text-white">Akan dikonfirmasi melalui WhatsApp</p>
								<p class="mt-1 text-xs text-white opacity-90">Pastikan nomor Anda benar</p>
							</div>
						</div>
					</div>
				</div>
			</main>
		</div>

		<script>
			document.querySelectorAll('input[name="tipe_pesanan"]').forEach(radio => {
				const label = radio.closest('label');
				if (radio.checked) {
					label.style.borderColor = '#dc0080';
					label.style.backgroundColor = '#fce7f3';
				}

				radio.addEventListener('change', function() {
					document.querySelectorAll('input[name="tipe_pesanan"]').forEach(r => {
						const l = r.closest('label');
						l.style.borderColor = '#e2e8f0';
						l.style.backgroundColor = 'transparent';
					});
					this.closest('label').style.borderColor = '#dc0080';
					this.closest('label').style.backgroundColor = '#fce7f3';
				});
			});

			function updateBorderAndBg(radio) {
				document.querySelectorAll('input[name="tipe_pesanan"]').forEach(r => {
					const l = r.closest('label');
					l.style.borderColor = '#e2e8f0';
					l.style.backgroundColor = 'transparent';
				});
				radio.closest('label').style.borderColor = '#dc0080';
				radio.closest('label').style.backgroundColor = '#fce7f3';
			}
		</script>
	</body>

</html>
