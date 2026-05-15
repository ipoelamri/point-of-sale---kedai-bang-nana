@extends('layouts.app')

@section('title', 'Dashboard Kasir - Pesanan Masuk')

@section('content')
	<div class="mb-6 flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center">
		<div>
			<h1 class="text-2xl font-bold text-white">Dashboard Kasir</h1>
			<p class="mt-1 text-sm text-slate-400">Kelola pesanan yang masuk</p>
		</div>
		<div class="flex items-center gap-2 rounded-xl bg-white/5 px-4 py-2 text-sm text-slate-400">
			<svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
				<path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
			</svg>
			<span id="current-time" class="font-medium text-white">{{ now()->format('H:i:s') }}</span>
		</div>
	</div>

	@if (session('success'))
		<div class="mb-6 rounded-xl border border-emerald-500/20 bg-emerald-500/10 p-4 text-sm text-emerald-300">
			{{ session('success') }}
		</div>
	@endif

	@if (session('error'))
		<div class="mb-6 rounded-xl border border-red-500/20 bg-red-500/10 p-4 text-sm text-red-300">
			{{ session('error') }}
		</div>
	@endif

	<!-- Tabs Status -->
	<div class="mb-6 flex gap-2 overflow-x-auto rounded-2xl glass-card p-2">
		<a href="{{ route('kasir.pesanan') }}?status=all"
			class="{{ request('status') !== 'pending' && request('status') !== 'lunas' && request('status') !== 'diproses' ? 'gradient-primary text-white shadow-lg shadow-pink-500/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }} rounded-xl px-4 py-2.5 text-sm font-semibold transition-all duration-200">
			Semua
		</a>
		<a href="{{ route('kasir.pesanan') }}?status=pending"
			class="{{ request('status') === 'pending' ? 'gradient-secondary text-white shadow-lg shadow-amber-500/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }} rounded-xl px-4 py-2.5 text-sm font-semibold transition-all duration-200">
			⏳ Menunggu Pembayaran
		</a>
		<a href="{{ route('kasir.pesanan') }}?status=lunas"
			class="{{ request('status') === 'lunas' ? 'gradient-success text-white shadow-lg shadow-emerald-500/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }} rounded-xl px-4 py-2.5 text-sm font-semibold transition-all duration-200">
			✓ Lunas
		</a>
		<a href="{{ route('kasir.pesanan') }}?status=diproses"
			class="{{ request('status') === 'diproses' ? 'gradient-info text-white shadow-lg shadow-blue-500/20' : 'text-slate-400 hover:text-white hover:bg-white/5' }} rounded-xl px-4 py-2.5 text-sm font-semibold transition-all duration-200">
			🍳 Sedang Diproses
		</a>
	</div>

	<!-- Orders List -->
	<div class="stagger-children grid gap-4">
		@if ($orders->count() > 0)
			@foreach ($orders as $order)
				<div class="glass-card overflow-hidden rounded-2xl transition-all duration-200 hover:shadow-xl
					{{ $order->status_order === 'pending' ? 'border-l-4 border-l-amber-500' : ($order->status_order === 'lunas' ? 'border-l-4 border-l-emerald-500' : 'border-l-4 border-l-blue-500') }}">
					<div class="p-5">
						<div class="mb-4 grid grid-cols-1 gap-4 lg:grid-cols-4">
							<!-- Order Info -->
							<div>
								<p class="text-[10px] font-semibold uppercase tracking-widest text-slate-500">No. Pesanan</p>
								<p class="mt-1 text-lg font-bold text-white">{{ $order->no_order }}</p>
								<p class="mt-1 text-xs text-slate-500">
									{{ $order->created_at->format('d/m/Y H:i') }}
								</p>
							</div>

							<!-- Customer Info -->
							<div>
								<p class="text-[10px] font-semibold uppercase tracking-widest text-slate-500">Pelanggan</p>
								<p class="mt-1 text-base font-semibold text-white">{{ $order->nama_pelanggan }}</p>
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
								<p class="text-[10px] font-semibold uppercase tracking-widest text-slate-500">Total</p>
								<p class="mt-1 text-xl font-bold text-amber-400">
									Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
								</p>
							</div>

							<!-- Status Badge -->
							<div class="flex items-end">
								<div>
									<p class="mb-2 text-[10px] font-semibold uppercase tracking-widest text-slate-500">Status</p>
									<span class="badge
										@if ($order->status_order === 'pending') badge-warning
										@elseif ($order->status_order === 'lunas') badge-success
										@else badge-info @endif">
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
						<div class="mb-4 rounded-xl bg-white/[0.03] p-3">
							<p class="mb-2 text-[10px] font-semibold uppercase tracking-widest text-slate-500">Items</p>
							<div class="space-y-1">
								@foreach ($order->orderItems as $item)
									<div class="flex justify-between text-sm">
										<span class="text-slate-300">{{ $item->menu->nama_menu }} ({{ $item->jumlah }}x)</span>
										<span class="font-medium text-slate-200">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
									</div>
								@endforeach
							</div>
						</div>

						<!-- Payment Info -->
						@if ($order->pembayaran)
							<div class="mb-4 text-sm text-slate-400">
								<p><span class="font-medium text-slate-300">Metode:</span>
									{{ ucfirst(str_replace('_', ' ', $order->pembayaran->metode_bayar ?? 'Belum terbayar')) }}</p>
								@if ($order->pembayaran->waktu_bayar)
									<p><span class="font-medium text-slate-300">Waktu:</span> {{ $order->pembayaran->waktu_bayar->format('d/m/Y H:i') }}</p>
								@endif
							</div>

							{{-- Tombol Konfirmasi Bayar Tunai --}}
							@if ($order->pembayaran->metode_bayar === 'tunai' && $order->pembayaran->status_bayar === 'menunggu_kasir')
								<div class="mb-4">
									<form action="{{ route('order.confirmCash', $order->id_order) }}" method="POST"
										onsubmit="return confirm('Konfirmasi pembayaran tunai Rp {{ number_format($order->total_bayar, 0, ',', '.') }}?')">
										@csrf
										<button type="submit" class="btn w-full text-xs py-2" style="background:rgba(16,185,129,0.15);color:#34d399;border:1px solid rgba(16,185,129,0.3);">
											💵 Konfirmasi Bayar Tunai — Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
										</button>
									</form>
								</div>
							@endif
						@endif

						<!-- Actions -->
						<div class="flex flex-wrap gap-2">
							<a href="{{ route('order.show', $order->id_order) }}" class="btn btn-ghost text-xs">
								Lihat Detail
							</a>

							@if ($order->status_order !== 'selesai')
								<form action="{{ route('order.updateStatus', $order->id_order) }}" method="POST" class="inline">
									@csrf
									<input type="hidden" name="status_order"
										value="{{ $order->status_order === 'pending' ? 'lunas' : ($order->status_order === 'lunas' ? 'diproses' : 'selesai') }}">
									<button type="submit" class="btn btn-secondary text-xs">
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
								<span class="badge badge-success">✓ Selesai</span>
							@endif

							<a href="{{ route('order.print', $order->id_order) }}" target="_blank"
								class="btn text-xs" style="background: rgba(59,130,246,0.15); color: #60a5fa; border: 1px solid rgba(59,130,246,0.2);">
								🖨️ Print
							</a>
						</div>
					</div>
				</div>
			@endforeach

			<!-- Pagination -->
			<div class="mt-4">
				{{ $orders->links() }}
			</div>
		@else
			<div class="glass-card rounded-2xl p-12 text-center">
				<p class="text-5xl mb-4">📋</p>
				<p class="text-lg font-medium text-slate-300">Tidak ada pesanan saat ini</p>
				<p class="mt-1 text-sm text-slate-500">Pesanan baru akan muncul di sini</p>
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
