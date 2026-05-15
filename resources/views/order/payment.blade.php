<!DOCTYPE html>
<html lang="id">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Pilih Pembayaran - Kedai Bang Nana</title>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
		@vite(['resources/css/app.css', 'resources/js/app.js'])
	</head>

	<body class="gradient-surface font-sans antialiased">
		<div class="flex min-h-screen flex-col">
			<!-- Header -->
			<header class="sticky top-0 z-50 glass-strong">
				<div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4">
					<div class="flex items-center gap-3">
						<div class="flex h-10 w-10 items-center justify-center rounded-xl gradient-primary shadow-lg">
							<span class="text-lg font-bold text-white">N</span>
						</div>
						<div>
							<h1 class="text-xl font-bold text-white">Kedai Bang <span class="text-gradient-primary">Nana</span></h1>
							<p class="text-xs text-slate-400">Café & Resto</p>
						</div>
					</div>
					<a href="{{ route('menu.public') }}" class="btn btn-ghost text-sm">← Kembali ke Menu</a>
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
						<div class="h-0.5 flex-1 gradient-primary mx-2"></div>
						<div class="flex flex-col items-center gap-1">
							<div class="flex h-8 w-8 items-center justify-center rounded-full gradient-primary text-sm font-bold text-white">3</div>
							<span class="text-xs font-semibold text-pink-400">Payment</span>
						</div>
					</div>
				</div>
			</div>

			<!-- Main Content -->
			<main class="mx-auto w-full max-w-4xl flex-1 px-4 py-6 sm:py-8">
				<div class="mb-8">
					<h2 class="text-2xl font-bold text-white">Pilih Metode Pembayaran</h2>
					<p class="mt-1 text-sm text-slate-400">Pilih cara pembayaran yang Anda inginkan</p>
				</div>

				<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
					<!-- Payment Methods -->
					<div class="space-y-4 lg:col-span-2">
						<!-- Pembayaran Tunai -->
						<form action="{{ route('pembayaran.cash', $order->id_order) }}" method="POST">
							@csrf
							<button type="submit"
								class="group w-full rounded-2xl glass-card p-6 text-left transition-all duration-200 hover:shadow-xl hover:border-emerald-500/30 glow-pink">
								<div class="flex items-center gap-5">
									<div class="flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-xl gradient-success shadow-lg shadow-emerald-500/20">
										<span class="text-2xl">💵</span>
									</div>
									<div class="flex-1">
										<h3 class="text-lg font-bold text-white">Bayar Tunai di Kasir</h3>
										<p class="mt-1 text-sm text-slate-400">Bayar langsung dengan uang tunai ke kasir</p>
										<div class="mt-3 flex gap-2">
											<span class="badge badge-success text-xs">Langsung</span>
											<span class="badge badge-success text-xs">Tanpa Biaya</span>
										</div>
									</div>
									<div class="text-2xl text-slate-400 transition-transform group-hover:translate-x-1">→</div>
								</div>
							</button>
						</form>

						<!-- Pembayaran Online (Midtrans) -->
						<a href="{{ route('pembayaran.snap', $order->id_order) }}"
							class="group block rounded-2xl glass-card p-6 transition-all duration-200 hover:shadow-xl hover:border-blue-500/30">
							<div class="flex items-center gap-5">
								<div class="flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-xl gradient-info shadow-lg shadow-blue-500/20">
									<span class="text-2xl">💳</span>
								</div>
								<div class="flex-1">
									<h3 class="text-lg font-bold text-white">Pembayaran Online (Midtrans)</h3>
									<p class="mt-1 text-sm text-slate-400">Gunakan kartu kredit, debit, e-wallet, atau transfer bank</p>
									<div class="mt-3 flex flex-wrap gap-2">
										<span class="badge badge-info text-xs">Kartu Kredit</span>
										<span class="badge badge-info text-xs">E-Wallet</span>
										<span class="badge badge-info text-xs">Transfer Bank</span>
										<span class="badge badge-info text-xs">QRIS</span>
									</div>
								</div>
								<div class="text-2xl text-slate-400 transition-transform group-hover:translate-x-1">→</div>
							</div>
						</a>

						<!-- Info -->
						<div class="rounded-xl border border-blue-500/20 bg-blue-500/10 p-4">
							<p class="text-sm text-blue-300">
								<strong>Saran:</strong> Gunakan pembayaran tunai jika Anda berada di kedai, atau pembayaran online untuk kemudahan.
							</p>
						</div>
					</div>

					<!-- Order Summary -->
					<div class="lg:sticky lg:top-24 lg:h-fit">
						<div class="glass-card rounded-2xl p-6">
							<h3 class="mb-5 text-lg font-bold text-white">Ringkasan Pesanan</h3>

							<div class="mb-4 rounded-xl bg-white/[0.03] p-4">
								<p class="text-xs font-medium uppercase tracking-wider text-slate-500">No. Pesanan</p>
								<p class="mt-1 text-lg font-bold text-white">{{ $order->no_order }}</p>
							</div>

							<div class="mb-5 max-h-48 space-y-3 overflow-y-auto border-b border-white/5 pb-5">
								@foreach ($orderItems as $item)
									<div class="flex items-start justify-between text-sm">
										<div>
											<p class="font-medium text-slate-200">{{ $item->menu->nama_menu }}</p>
											<p class="text-xs text-slate-500">{{ $item->jumlah }} x Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
										</div>
										<p class="font-semibold text-slate-200">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
									</div>
								@endforeach
							</div>

							<div class="mb-4 space-y-2 text-sm">
								<div class="flex justify-between text-slate-400">
									<span>Subtotal</span>
									<span class="text-slate-300">Rp {{ number_format($order->total_bayar / 1.1, 0, ',', '.') }}</span>
								</div>
								<div class="flex justify-between text-slate-400">
									<span>PPN (10%)</span>
									<span class="text-slate-300">Rp {{ number_format(($order->total_bayar / 1.1) * 0.1, 0, ',', '.') }}</span>
								</div>
							</div>

							<div class="rounded-xl gradient-primary p-4 text-center">
								<p class="text-xs font-medium text-white/80">Total Pembayaran</p>
								<p class="mt-1 text-2xl font-bold text-white">
									Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
								</p>
							</div>

							@if ($order->tipe_pesanan == 'dine-in' && $order->no_meja)
								<div class="mt-4 rounded-xl border border-emerald-500/20 bg-emerald-500/10 p-3 text-center">
									<p class="text-sm text-emerald-300">
										<strong>Meja:</strong> {{ $order->no_meja }}
									</p>
								</div>
							@endif
						</div>
					</div>
				</div>
			</main>

			<footer class="mt-8 glass py-6 text-center text-sm text-slate-500">
				<p>&copy; 2026 Kedai Bang Nana. Semua hak cipta dilindungi.</p>
			</footer>
		</div>
	</body>

</html>
