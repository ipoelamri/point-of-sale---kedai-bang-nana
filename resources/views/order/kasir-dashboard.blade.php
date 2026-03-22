@extends('layouts.app')

@section('title', 'Dashboard Kasir - Pesanan Masuk')

@section('content')
	<div class="mb-6 flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
		<div>
			<h1 class="rounded-lg px-6 py-3 text-3xl font-bold text-white"
				style="background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);">Dashboard Kasir</h1>
			<p class="mt-3 text-slate-300">Kelola pesanan yang masuk</p>
		</div>
		<div class="text-sm text-slate-400">
			<p>Diperbarui: <span id="current-time" class="font-semibold">{{ now()->format('H:i:s') }}</span></p>
		</div>
	</div>

	@if (session('success'))
		<div class="mb-6 rounded-lg border border-emerald-900 bg-emerald-950 p-4 text-emerald-300">
			{{ session('success') }}
		</div>
	@endif

	@if (session('error'))
		<div class="mb-6 rounded-lg border border-rose-900 bg-rose-950 p-4 text-rose-300">
			{{ session('error') }}
		</div>
	@endif

	<!-- Tabs Status -->
	<div class="sticky top-20 z-40 mb-6 rounded-xl bg-slate-800 p-4 shadow-sm">
		<div class="flex gap-4 overflow-x-auto pb-2">
			<a href="{{ route('kasir.pesanan') }}?status=all"
				class="{{ request('status') !== 'pending' && request('status') !== 'lunas' && request('status') !== 'diproses' ? 'text-white' : 'bg-slate-900 text-slate-400 hover:bg-slate-800' }} rounded-lg px-4 py-2 font-medium transition"
				style="{{ request('status') !== 'pending' && request('status') !== 'lunas' && request('status') !== 'diproses' ? 'background: linear-gradient(135deg, #dc0080 0%, #d90b84 100%);' : '' }}">
				Semua
			</a>
			<a href="{{ route('kasir.pesanan') }}?status=pending"
				class="{{ request('status') === 'pending' ? 'text-white' : 'bg-slate-900 text-slate-400 hover:bg-slate-800' }} rounded-lg px-4 py-2 font-medium transition"
				style="{{ request('status') === 'pending' ? 'background: linear-gradient(135deg, #10b981 0%, #059669 100%);' : '' }}">
				⏳ Menunggu Pembayaran
			</a>
			<a href="{{ route('kasir.pesanan') }}?status=lunas"
				class="{{ request('status') === 'lunas' ? 'text-white' : 'bg-slate-900 text-slate-400 hover:bg-slate-800' }} rounded-lg px-4 py-2 font-medium transition"
				style="{{ request('status') === 'lunas' ? 'background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);' : '' }}">
				✓ Lunas
			</a>
			<a href="{{ route('kasir.pesanan') }}?status=diproses"
				class="{{ request('status') === 'diproses' ? 'text-white' : 'bg-slate-900 text-slate-400 hover:bg-slate-800' }} rounded-lg px-4 py-2 font-medium transition"
				style="{{ request('status') === 'diproses' ? 'background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);' : '' }}">
				🍳 Sedang Diproses
			</a>
		</div>
	</div>

	<!-- Orders List -->
	<div class="grid gap-6">
		@if ($orders->count() > 0)
			@foreach ($orders as $order)
				<div
					class="{{ $order->status_order === 'pending' ? 'border-l-blue-500' : ($order->status_order === 'lunas' ? 'border-l-emerald-500' : 'border-l-orange-500') }} overflow-hidden rounded-xl border-l-4 bg-slate-800 shadow-sm transition hover:shadow-md">
					<div class="p-6">
						<div class="mb-4 grid grid-cols-1 gap-4 lg:grid-cols-4">
							<!-- Order Info -->
							<div>
								<p class="text-xs font-semibold text-slate-400">NO. PESANAN</p>
								<p class="text-xl font-bold text-white">{{ $order->no_order }}</p>
								<p class="mt-1 text-xs text-slate-500">
									{{ $order->created_at->format('d/m/Y H:i') }}
								</p>
							</div>

							<!-- Customer Info -->
							<div>
								<p class="text-xs font-semibold text-slate-400">PELANGGAN</p>
								<p class="text-lg font-semibold text-white">{{ $order->nama_pelanggan }}</p>
								<p class="mt-1 text-xs text-slate-400">
									@if ($order->tipe_pesanan === 'dine-in')
										Meja {{ $order->no_meja ?? '-' }}
									@else
										Bawa Pulang
									@endif
								</p>
							</div>

							<!-- Amount -->
							<div>
								<p class="text-xs font-semibold text-slate-400">TOTAL</p>
								<p class="text-2xl font-bold text-amber-400">
									Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
								</p>
							</div>

							<!-- Status Badge -->
							<div class="flex items-end">
								<div>
									<p class="mb-2 text-xs font-semibold text-slate-400">STATUS</p>
									<span
										class="{{ $order->status_order === 'pending' ? 'bg-blue-900 text-blue-200' : ($order->status_order === 'lunas' ? 'bg-emerald-900 text-emerald-200' : 'bg-orange-900 text-orange-200') }} inline-block rounded-full px-3 py-2 text-sm font-semibold">
										@if ($order->status_order === 'pending')
											⏳ Menunggu Pembayaran
										@elseif ($order->status_order === 'lunas')
											✓ Lunas
										@else
											🍳 Sedang Diproses
										@endif
									</span>
								</div>
							</div>
						</div>

						<!-- Items -->
						<div class="mb-4 rounded-lg bg-slate-800 p-3">
							<p class="mb-2 text-xs font-semibold text-slate-300">ITEMS:</p>
							<div class="space-y-1">
								@foreach ($order->orderItems as $item)
									<div class="flex justify-between text-sm text-slate-300">
										<span>{{ $item->menu->nama_menu }} ({{ $item->jumlah }}x)</span>
										<span class="font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
									</div>
								@endforeach
							</div>
						</div>

						<!-- Payment Info -->
						@if ($order->pembayaran)
							<div class="mb-4 text-sm text-slate-300">
								<p><strong>Metode:</strong>
									{{ ucfirst(str_replace('_', ' ', $order->pembayaran->metode_bayar ?? 'Belum terbayar')) }}</p>
								@if ($order->pembayaran->waktu_bayar)
									<p><strong>Waktu:</strong> {{ $order->pembayaran->waktu_bayar->format('d/m/Y H:i') }}</p>
								@endif
							</div>
						@endif

						<!-- Actions -->
						<div class="flex flex-wrap gap-3">
							<a href="{{ route('order.show', $order->id_order) }}"
								class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-medium text-slate-300 transition hover:bg-slate-700">
								Lihat Detail
							</a>

							@if ($order->status_order !== 'selesai')
								<form action="{{ route('order.updateStatus', $order->id_order) }}" method="POST" class="inline">
									@csrf
									<input type="hidden" name="status_order"
										value="{{ $order->status_order === 'pending' ? 'lunas' : ($order->status_order === 'lunas' ? 'diproses' : 'selesai') }}">
									<button type="submit" class="rounded-lg px-4 py-2 text-sm font-medium text-white transition hover:shadow-lg"
										style="background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);">
										@if ($order->status_order === 'pending')
											Tandai Lunas
										@elseif ($order->status_order === 'lunas')
											Mulai Proses
										@else
											Selesai
										@endif
									</button>
								</form>
							@else
								<span class="rounded-lg bg-emerald-900 px-4 py-2 text-sm font-medium text-emerald-200">
									✓ Selesai
								</span>
							@endif

							<a href="{{ route('order.print', $order->id_order) }}" target="_blank"
								class="rounded-lg bg-blue-900 px-4 py-2 text-sm font-medium text-blue-200 transition hover:bg-blue-800">
								🖨️ Print
							</a>
						</div>
					</div>
				</div>
			@endforeach

			<!-- Pagination -->
			<div class="mt-6">
				{{ $orders->links() }}
			</div>
		@else
			<div class="rounded-xl bg-white p-12 text-center shadow-sm">
				<p class="text-lg text-slate-600">Tidak ada pesanan saat ini</p>
			</div>
		@endif
	</div>

	<script>
		// Update waktu real-time
		setInterval(function() {
			const now = new Date();
			document.getElementById('current-time').textContent = now.toLocaleTimeString('id-ID');
		}, 1000);

		// Auto refresh setiap 30 detik
		setInterval(function() {
			location.reload();
		}, 30000);
	</script>
@endsection
