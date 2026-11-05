<!DOCTYPE html>
<html lang="id">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Pembayaran Tunai - Kedai Bang Nana</title>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
		<!-- Lucide Icons -->
		<script src="https://unpkg.com/lucide@latest"></script>
		@vite(['resources/css/app.css', 'resources/js/app.js'])
	</head>

	<body class="gradient-surface font-sans antialiased">
		<div class="flex min-h-screen flex-col">
			<!-- Header -->
			<header class="glass-strong">
				<div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4">
					<div class="flex items-center gap-3">
						<img src="{{ asset('images/logo.png') }}" alt="Kedai Bang Nana" class="h-10 w-auto object-contain drop-shadow-[0_4px_12px_rgba(236,72,153,0.3)]">
						<div>
							<h1 class="text-xl font-bold text-white">Kedai Bang <span class="text-gradient-primary">Nana</span></h1>
							<p class="text-xs text-slate-400">Café & Resto</p>
						</div>
					</div>
				</div>
			</header>

			<!-- Main Content -->
			<main class="mx-auto flex w-full max-w-lg flex-1 flex-col justify-center px-4 py-8">
				<div class="glass-card animate-fade-in-up rounded-2xl p-8 text-center">
					<!-- Success Icon -->
					<div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full gradient-success shadow-lg shadow-emerald-500/25">
						<i data-lucide="check" class="w-10 h-10 text-white"></i>
					</div>

					<h2 class="mb-2 text-2xl font-bold text-white">Pesanan Berhasil Dibuat!</h2>
					<p class="mb-6 text-slate-400">Silakan bayar tunai ke kasir dengan menunjukkan nomor pesanan ini</p>

					<!-- Order Number -->
					<div class="mb-6 rounded-xl bg-white/5 p-6">
						<p class="text-xs font-semibold uppercase tracking-widest text-slate-500">Nomor Pesanan Anda</p>
						<p class="mt-2 text-3xl font-bold text-gradient-primary">{{ $order->no_order }}</p>
					</div>

					<!-- Payment Details -->
					<div class="mb-6 space-y-3 rounded-xl bg-white/[0.03] p-5 text-left">
						<div class="flex justify-between text-sm">
							<span class="text-slate-400">Pelanggan</span>
							<span class="font-medium text-white">{{ $order->nama_pelanggan }}</span>
						</div>
						<div class="flex justify-between text-sm">
							<span class="text-slate-400">Tipe Pesanan</span>
							<span class="font-medium text-white">
								{{ $order->tipe_pesanan === 'Dine In' ? 'Makan di Tempat' : 'Bawa Pulang' }}
								@if ($order->no_meja)
									(Meja {{ $order->no_meja }})
								@endif
							</span>
						</div>
						<div class="flex justify-between text-sm">
							<span class="text-slate-400">Metode Bayar</span>
							<span class="badge badge-success">Tunai</span>
						</div>
						<div class="flex justify-between text-sm">
							<span class="text-slate-400">Status</span>
							<span class="badge badge-warning">Menunggu Kasir</span>
						</div>
						<div class="border-t border-white/5 pt-3">
							<div class="flex items-baseline justify-between">
								<span class="font-semibold text-slate-300">Total Bayar</span>
								<span class="text-2xl font-bold text-amber-400">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</span>
							</div>
						</div>
					</div>

					<!-- Instructions -->
					<div class="mb-6 rounded-xl border border-amber-500/20 bg-amber-500/10 p-4 text-left">
						<h4 class="mb-2 font-semibold text-amber-300">Langkah Selanjutnya:</h4>
						<ol class="space-y-1 text-sm text-amber-200/80">
							<li>1. Tunjukkan nomor pesanan ke kasir</li>
							<li>2. Bayar sejumlah <strong>Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</strong></li>
							<li>3. Kasir akan mengkonfirmasi pembayaran</li>
							<li>4. Pesanan Anda akan segera diproses</li>
						</ol>
					</div>

					<a href="{{ route('menu.public') }}" class="btn btn-primary w-full py-3 inline-flex items-center justify-center gap-2">
						<i data-lucide="arrow-left" class="w-4 h-4"></i>
						<span>Kembali ke Menu</span>
					</a>
				</div>
			</main>

			<footer class="glass py-6 text-center text-sm text-slate-500">
				<p>&copy; 2026 Kedai Bang Nana. Semua hak cipta dilindungi.</p>
			</footer>
		</div>

		<!-- Lucide Init -->
		<script>
			if (window.lucide) {
				lucide.createIcons();
			}
		</script>
	</body>

</html>
