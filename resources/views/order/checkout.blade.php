<!DOCTYPE html>
<html lang="id">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Checkout - Kedai Bang Nana</title>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
		@vite(['resources/css/app.css', 'resources/js/app.js'])
	</head>
	<body class="gradient-surface font-sans antialiased">
		<div class="flex min-h-screen flex-col">
			<header class="sticky top-0 z-50 glass-strong">
				<div class="mx-auto max-w-7xl px-4 py-4">
					<div class="flex items-center justify-between gap-4">
						<div class="flex items-center gap-3">
							<div class="flex h-10 w-10 items-center justify-center rounded-xl gradient-primary shadow-lg"><span class="text-lg font-bold text-white">N</span></div>
							<div>
								<h1 class="text-xl font-bold text-white">Kedai Bang <span class="text-gradient-primary">Nana</span></h1>
								<p class="text-xs text-slate-400">Café & Resto</p>
							</div>
						</div>
						<a href="{{ route('cart.view') }}" class="btn btn-ghost text-sm">← Kembali ke Keranjang</a>
					</div>
				</div>
			</header>

			<!-- Progress Bar -->
			<div class="glass border-b border-white/5">
				<div class="mx-auto max-w-7xl px-4 py-6">
					<div class="flex items-center justify-between">
						<div class="flex flex-col items-center gap-1">
							<div class="flex h-8 w-8 items-center justify-center rounded-full gradient-primary text-sm font-bold text-white">1</div>
							<span class="text-xs font-semibold text-pink-400">Cart</span>
						</div>
						<div class="h-0.5 flex-1 gradient-primary mx-2"></div>
						<div class="flex flex-col items-center gap-1">
							<div class="flex h-8 w-8 items-center justify-center rounded-full gradient-primary text-sm font-bold text-white">2</div>
							<span class="text-xs font-semibold text-pink-400">Checkout</span>
						</div>
						<div class="h-0.5 flex-1 bg-slate-700 mx-2"></div>
						<div class="flex flex-col items-center gap-1">
							<div class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-700 text-sm font-bold text-slate-400">3</div>
							<span class="text-xs text-slate-500">Payment</span>
						</div>
					</div>
				</div>
			</div>

			<main class="mx-auto w-full max-w-7xl flex-1 px-4 py-6 sm:py-8">
				<div class="mb-8">
					<h2 class="text-2xl font-bold text-white">📝 Checkout Pesanan</h2>
					<p class="mt-1 text-sm text-slate-400">Lengkapi informasi pesanan Anda</p>
				</div>

				<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
					<div class="glass-card animate-fade-in-up rounded-2xl p-6 sm:p-8 lg:col-span-2">
						<h3 class="mb-6 text-lg font-bold text-white">🛎️ Informasi Pesanan</h3>

						@if ($errors->any())
							<div class="mb-6 rounded-xl border border-red-500/20 bg-red-500/10 p-4">
								<h4 class="mb-2 font-semibold text-red-300">⚠️ Perbaiki Error:</h4>
								<ul class="space-y-1 text-sm text-red-400">
									@foreach ($errors->all() as $error)
										<li>• {{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif

						<form action="{{ route('order.checkout') }}" method="POST" class="space-y-5">
							@csrf
							<div>
								<label class="form-label" for="nama_pemesan">👤 Nama Pemesan</label>
								<input id="nama_pemesan" type="text" name="nama_pemesan" value="{{ old('nama_pemesan') }}"
									class="form-input" placeholder="Masukkan nama Anda" required>
								@error('nama_pemesan')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
							</div>

							<div>
								<label class="form-label">🏠 Tipe Pesanan</label>
								<div class="space-y-2">
									@foreach (['Dine In' => 'Makan di Tempat', 'Take Away' => 'Bawa Pulang'] as $value => $label)
										<label class="flex cursor-pointer items-center gap-4 rounded-xl border border-white/5 bg-white/[0.02] p-4 transition-all hover:border-pink-500/30 hover:bg-pink-500/5 has-[:checked]:border-pink-500/40 has-[:checked]:bg-pink-500/10">
											<input type="radio" name="tipe_pesanan" value="{{ $value }}"
												{{ old('tipe_pesanan') == $value ? 'checked' : '' }} class="h-4 w-4 accent-pink-500">
											<div>
												<p class="font-semibold text-white">{{ $label }}</p>
												<p class="text-sm text-slate-400">{{ $value === 'Dine In' ? 'Pesan untuk dimakan di restoran' : 'Pesan untuk dibawa pulang' }}</p>
											</div>
										</label>
									@endforeach
								</div>
								@error('tipe_pesanan')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
							</div>

							<div>
								<label class="form-label" for="no_meja">🎫 Nomor Meja <span class="text-slate-500">(Untuk Dine In)</span></label>
								<input id="no_meja" type="text" name="no_meja" value="{{ old('no_meja') }}" class="form-input" placeholder="Masukkan nomor meja">
								@error('no_meja')<p class="mt-1.5 text-xs text-red-400">{{ $message }}</p>@enderror
							</div>

							<div class="flex flex-col gap-3 pt-4 sm:flex-row">
								<a href="{{ route('cart.view') }}" class="btn btn-ghost flex-1">← Kembali</a>
								<button type="submit" class="btn btn-primary flex-1 py-3">✓ Lanjut ke Pembayaran</button>
							</div>
						</form>
					</div>

					<div class="lg:sticky lg:top-24 lg:h-fit">
						<div class="glass-card rounded-2xl p-6">
							<h3 class="mb-5 text-lg font-bold text-white">📋 Ringkasan Pesanan</h3>
							<div class="mb-5 space-y-3 border-b border-white/5 pb-5">
								@php $grandTotal = 0; @endphp
								@foreach ($cart as $menuId => $item)
									@php $subtotal = $item['harga'] * $item['quantity']; $grandTotal += $subtotal; @endphp
									<div class="flex justify-between text-sm">
										<span class="text-slate-300">{{ $item['quantity'] }}x {{ $item['nama_menu'] }}</span>
										<span class="font-medium text-white">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
									</div>
								@endforeach
							</div>
							<div class="mb-5 flex items-baseline justify-between">
								<span class="font-bold text-slate-300">Total</span>
								<span class="text-2xl font-bold text-pink-400">Rp {{ number_format($total, 0, ',', '.') }}</span>
							</div>
							<div class="rounded-xl gradient-primary p-4 text-center">
								<p class="text-sm font-semibold text-white">Akan dikonfirmasi melalui WhatsApp</p>
								<p class="mt-1 text-xs text-white/80">Pastikan nomor Anda benar</p>
							</div>
						</div>
					</div>
				</div>
			</main>
		</div>
	</body>
</html>
