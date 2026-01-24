<!DOCTYPE html>
<html lang="id">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Pilih Pembayaran - Kedai Bang Nana</title>
		@vite(['resources/css/app.css', 'resources/js/app.js'])
	</head>

	<body class="bg-slate-50">
		<div class="flex min-h-screen flex-col">
			<!-- Header -->
			<header class="sticky top-0 z-50 bg-white shadow-sm">
				<div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4">
					<div>
						<h1 class="text-2xl font-bold text-amber-600">Kedai Bang Nana</h1>
						<p class="text-sm text-slate-600">Café & Resto</p>
					</div>
					<a href="{{ route('menu.public') }}" class="font-medium text-amber-600 hover:text-amber-800">
						← Kembali ke Menu
					</a>
				</div>
			</header>

			<!-- Main Content -->
			<main class="mx-auto w-full max-w-4xl flex-1 px-4 py-8">
				<h2 class="mb-8 text-3xl font-bold text-slate-800">Pilih Metode Pembayaran</h2>

				<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
					<!-- Payment Methods -->
					<div class="space-y-4 lg:col-span-2">
						<!-- E-Wallet / Online Payment -->
						<a href="{{ route('pembayaran.snap', $order->id_order) }}"
							class="block rounded-xl border-2 border-transparent bg-white p-6 shadow-sm transition hover:border-amber-300 hover:bg-amber-50 hover:shadow-md">
							<div class="flex items-center gap-4">
								<div class="text-4xl">💳</div>
								<div>
									<h3 class="text-xl font-semibold text-slate-800">Pembayaran Online (Midtrans)</h3>
									<p class="mt-1 text-sm text-slate-600">Gunakan kartu kredit, debit, e-wallet, atau
										transfer bank</p>
									<div class="mt-3 flex gap-2">
										<span class="rounded bg-blue-100 px-2 py-1 text-xs text-blue-800">💳 Kartu Kredit</span>
										<span class="rounded bg-blue-100 px-2 py-1 text-xs text-blue-800">📱 E-Wallet</span>
										<span class="rounded bg-blue-100 px-2 py-1 text-xs text-blue-800">🏦 Transfer Bank</span>
									</div>
								</div>
								<div class="text-2xl">→</div>
							</div>
						</a>

						<!-- Saran Pembayaran -->
						<div class="rounded-xl border border-blue-200 bg-blue-50 p-4">
							<p class="text-sm text-blue-900">
								<strong>💡 Saran:</strong> Gunakan metode pembayaran online untuk pengalaman yang cepat
								dan aman.
							</p>
						</div>
					</div>

					<!-- Order Summary -->
					<div class="sticky top-24 h-fit rounded-xl bg-white p-6 shadow-sm">
						<h3 class="mb-4 text-xl font-semibold text-slate-800">Ringkasan Pesanan</h3>

						<div class="mb-4 rounded-lg bg-slate-50 p-4">
							<p class="text-sm text-slate-600">No. Pesanan:</p>
							<p class="text-lg font-semibold text-slate-800">{{ $order->no_order }}</p>
						</div>

						<div class="mb-6 max-h-64 space-y-3 overflow-y-auto border-b border-slate-200 pb-4">
							@foreach ($orderItems as $item)
								<div class="flex items-start justify-between text-sm">
									<div>
										<p class="font-medium text-slate-800">{{ $item->menu->nama_menu }}</p>
										<p class="text-xs text-slate-600">{{ $item->jumlah }} x Rp
											{{ number_format($item->harga_satuan, 0, ',', '.') }}</p>
									</div>
									<p class="font-semibold text-slate-800">
										Rp {{ number_format($item->subtotal, 0, ',', '.') }}
									</p>
								</div>
							@endforeach
						</div>

						<div class="mb-4 space-y-2">
							<div class="flex justify-between text-sm text-slate-600">
								<span>Subtotal:</span>
								<span>Rp {{ number_format($order->total_bayar / 1.1, 0, ',', '.') }}</span>
							</div>
							<div class="flex justify-between text-sm text-slate-600">
								<span>PPN (10%):</span>
								<span>Rp {{ number_format(($order->total_bayar / 1.1) * 0.1, 0, ',', '.') }}</span>
							</div>
						</div>

						<div class="rounded-lg border-2 border-amber-200 bg-amber-50 p-4">
							<p class="mb-1 text-sm text-amber-600">Total Pembayaran:</p>
							<p class="text-3xl font-bold text-amber-600">
								Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
							</p>
						</div>

						@if ($order->tipe_pesanan == 'dine-in' && $order->no_meja)
							<div class="mt-4 rounded-lg border border-emerald-200 bg-emerald-50 p-3">
								<p class="text-sm text-emerald-800">
									<strong>📍 Meja:</strong> {{ $order->no_meja }}
								</p>
							</div>
						@endif
					</div>
				</div>
			</main>

			<!-- Footer -->
			<footer class="mt-8 bg-slate-100 py-4 text-center text-slate-600">
				<p>&copy; 2026 Kedai Bang Nana. Semua hak cipta dilindungi.</p>
			</footer>
		</div>
	</body>

</html>
