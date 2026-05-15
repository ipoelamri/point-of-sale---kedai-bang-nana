<!DOCTYPE html>
<html lang="id">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Keranjang - Kedai Bang Nana</title>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
		@vite(['resources/css/app.css', 'resources/js/app.js'])
	</head>
	<body class="gradient-surface font-sans antialiased">
		<div class="flex min-h-screen flex-col">
			<header class="sticky top-0 z-50 glass-strong">
				<div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4">
					<div class="flex items-center gap-3">
						<div class="flex h-10 w-10 items-center justify-center rounded-xl gradient-primary shadow-lg"><span class="text-lg font-bold text-white">N</span></div>
						<div>
							<h1 class="text-xl font-bold text-white">Kedai Bang <span class="text-gradient-primary">Nana</span></h1>
							<p class="text-xs text-slate-400">Café & Resto</p>
						</div>
					</div>
					<a href="{{ route('menu.public') }}" class="btn btn-ghost text-sm">← Kembali ke Menu</a>
				</div>
			</header>

			<main class="mx-auto w-full max-w-4xl flex-1 px-4 py-6 sm:py-8">
				<div class="mb-8">
					<h2 class="text-2xl font-bold text-white">🛒 Keranjang Belanja</h2>
					<p class="mt-1 text-sm text-slate-400">Periksa pesanan Anda sebelum checkout</p>
				</div>

				@if (session('success'))
					<div class="mb-6 rounded-xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-sm text-emerald-300">✓ {{ session('success') }}</div>
				@endif

				@if (count($cart) > 0)
					<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
						<div class="lg:col-span-2">
							<!-- Desktop -->
							<div class="hidden glass-card overflow-hidden rounded-2xl sm:block">
								<table class="w-full">
									<thead>
										<tr class="border-b border-white/5">
											<th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Menu</th>
											<th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-400">Harga</th>
											<th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-400">Qty</th>
											<th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-400">Subtotal</th>
											<th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-400">Aksi</th>
										</tr>
									</thead>
									<tbody class="divide-y divide-white/5">
										@php $grandTotal = 0; @endphp
										@foreach ($cart as $menuId => $item)
											@php $subtotal = $item['harga'] * $item['quantity']; $grandTotal += $subtotal; @endphp
											<tr class="hover:bg-white/[0.02]">
												<td class="px-6 py-4">
													<div class="flex gap-3">
														<img src="{{ asset('storage/' . $item['foto']) }}" alt="{{ $item['nama_menu'] }}" class="h-14 w-14 rounded-xl object-cover ring-1 ring-white/10">
														<div>
															<p class="font-semibold text-white">{{ $item['nama_menu'] }}</p>
															<p class="mt-1 text-xs text-slate-500">Menu</p>
														</div>
													</div>
												</td>
												<td class="px-6 py-4 text-right text-sm text-slate-300">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
												<td class="px-6 py-4 text-center">
													<span class="rounded-lg bg-white/5 px-3 py-1 text-sm font-bold text-white">{{ $item['quantity'] }}</span>
												</td>
												<td class="px-6 py-4 text-right font-bold text-pink-400">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
												<td class="px-6 py-4 text-center">
													<form action="{{ route('cart.remove', $menuId) }}" method="POST" style="display:inline;">
														@csrf @method('DELETE')
														<button type="submit" class="btn text-xs" style="background:rgba(239,68,68,0.15);color:#f87171;border:1px solid rgba(239,68,68,0.2);">🗑 Hapus</button>
													</form>
												</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>

							<!-- Mobile -->
							<div class="space-y-3 sm:hidden">
								@php $grandTotal = 0; @endphp
								@foreach ($cart as $menuId => $item)
									@php $subtotal = $item['harga'] * $item['quantity']; $grandTotal += $subtotal; @endphp
									<div class="glass-card rounded-2xl p-4">
										<div class="mb-3 flex gap-3">
											<img src="{{ asset('storage/' . $item['foto']) }}" alt="{{ $item['nama_menu'] }}" class="h-16 w-16 flex-shrink-0 rounded-xl object-cover ring-1 ring-white/10">
											<div class="flex-1">
												<p class="font-bold text-white">{{ $item['nama_menu'] }}</p>
												<p class="mt-1 text-sm text-slate-400">Rp {{ number_format($item['harga'], 0, ',', '.') }}/item</p>
											</div>
										</div>
										<div class="flex items-center justify-between border-t border-white/5 pt-3">
											<div>
												<p class="text-xs text-slate-500">Qty</p>
												<span class="rounded-lg bg-white/5 px-3 py-1 text-sm font-bold text-white">{{ $item['quantity'] }}</span>
											</div>
											<div class="text-right">
												<p class="text-xs text-slate-500">Subtotal</p>
												<p class="font-bold text-pink-400">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
											</div>
											<form action="{{ route('cart.remove', $menuId) }}" method="POST" style="display:inline;">
												@csrf @method('DELETE')
												<button type="submit" class="btn text-xs" style="background:rgba(239,68,68,0.15);color:#f87171;border:1px solid rgba(239,68,68,0.2);">Hapus</button>
											</form>
										</div>
									</div>
								@endforeach
							</div>
						</div>

						<div class="lg:col-span-1">
							<div class="sticky top-24 glass-card glow-pink rounded-2xl p-6">
								<h3 class="mb-6 text-lg font-bold text-white">📋 Ringkasan Pesanan</h3>
								<div class="mb-6 space-y-3 border-b border-white/5 pb-6">
									<div class="flex justify-between text-sm"><span class="text-slate-400">Subtotal</span><span class="font-medium text-white">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span></div>
									@php $ppn = $grandTotal * 0.1; @endphp
									<div class="flex justify-between text-sm"><span class="text-slate-400">PPN 10%</span><span class="font-medium text-white">Rp {{ number_format($ppn, 0, ',', '.') }}</span></div>
								</div>
								<div class="mb-6">
									<div class="flex items-baseline justify-between">
										<span class="font-bold text-slate-300">Total Bayar</span>
										<span class="text-2xl font-bold text-pink-400">Rp {{ number_format($total, 0, ',', '.') }}</span>
									</div>
								</div>
								<div class="space-y-3">
									<a href="{{ route('menu.public') }}" class="btn btn-ghost w-full">← Lanjut Belanja</a>
									<a href="{{ route('order.checkout') }}" class="btn btn-primary w-full py-3">✓ Lanjut ke Pembayaran →</a>
								</div>
								<div class="mt-6 space-y-1 text-center text-xs text-slate-500">
									<p>✓ Pembayaran Aman & Terenkripsi</p>
									<p>✓ Proses Cepat & Mudah</p>
								</div>
							</div>
						</div>
					</div>
				@else
					<div class="glass-card rounded-2xl p-12 text-center">
						<div class="mb-4 text-5xl">🛒</div>
						<p class="mb-2 text-lg font-medium text-white">Keranjang Anda kosong</p>
						<p class="mb-8 text-sm text-slate-400">Mulai pilih menu favorit Anda</p>
						<a href="{{ route('menu.public') }}" class="btn btn-primary">← Kembali ke Menu</a>
					</div>
				@endif
			</main>

			<footer class="mt-12 glass py-6 text-center text-sm text-slate-500">
				<p>&copy; 2026 Kedai Bang Nana. Semua hak cipta dilindungi.</p>
			</footer>
		</div>
	</body>
</html>
