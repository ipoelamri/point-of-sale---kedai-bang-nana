@extends('layouts.app')

@section('title', 'Detail Pesanan - ' . $order->no_order)

@section('content')
	<div class="mb-6 flex items-center justify-between">
		<div>
			<h1 class="text-2xl font-bold text-white">Detail Pesanan</h1>
			<p class="mt-1 text-sm text-slate-400">{{ $order->no_order }}</p>
		</div>
		<a href="{{ route('kasir.pesanan') }}" class="btn btn-ghost text-sm">← Kembali</a>
	</div>

	<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
		<div class="space-y-6 lg:col-span-2">
			<div class="glass-card rounded-2xl p-6">
				<h2 class="mb-5 text-lg font-bold text-white">Informasi Pesanan</h2>
				<div class="grid grid-cols-2 gap-5">
					<div>
						<p class="text-[10px] font-semibold uppercase tracking-widest text-slate-500">No. Pesanan</p>
						<p class="mt-1 text-lg font-bold text-white">{{ $order->no_order }}</p>
					</div>
					<div>
						<p class="text-[10px] font-semibold uppercase tracking-widest text-slate-500">Waktu</p>
						<p class="mt-1 text-sm text-slate-300">{{ $order->created_at->format('d/m/Y H:i:s') }}</p>
					</div>
					<div>
						<p class="text-[10px] font-semibold uppercase tracking-widest text-slate-500">Nama Pelanggan</p>
						<p class="mt-1 text-lg font-bold text-white">{{ $order->nama_pelanggan }}</p>
					</div>
					<div>
						<p class="text-[10px] font-semibold uppercase tracking-widest text-slate-500">Tipe Pesanan</p>
						<p class="mt-1 text-sm text-slate-300">
							@if ($order->tipe_pesanan === 'dine-in')
								Makan di Tempat (Meja {{ $order->no_meja ?? '-' }})
							@else
								Bawa Pulang
							@endif
						</p>
					</div>
					<div>
						<p class="text-[10px] font-semibold uppercase tracking-widest text-slate-500">Status</p>
						<span class="badge mt-1 @if($order->status_order === 'pending') badge-warning @elseif($order->status_order === 'lunas') badge-success @elseif($order->status_order === 'diproses') badge-info @else badge-neutral @endif">
							{{ ucfirst(str_replace('_', ' ', $order->status_order)) }}
						</span>
					</div>
					<div>
						<p class="text-[10px] font-semibold uppercase tracking-widest text-slate-500">Kasir</p>
						<p class="mt-1 text-sm text-slate-300">{{ $order->kasir->username ?? 'Self-Service' }}</p>
					</div>
				</div>
			</div>

			<div class="glass-card overflow-hidden rounded-2xl">
				<div class="p-6 pb-3"><h2 class="text-lg font-bold text-white">Daftar Item</h2></div>
				<div class="overflow-x-auto">
					<table class="w-full">
						<thead>
							<tr class="border-b border-white/5">
								<th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-400">Menu</th>
								<th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-400">Harga</th>
								<th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-400">Qty</th>
								<th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-400">Subtotal</th>
							</tr>
						</thead>
						<tbody class="divide-y divide-white/5">
							@foreach ($order->orderItems as $item)
								<tr class="hover:bg-white/[0.02]">
									<td class="px-6 py-4">
										<div class="flex items-center gap-3">
											<img src="{{ asset('storage/' . $item->menu->foto) }}" alt="{{ $item->menu->nama_menu }}" class="h-10 w-10 rounded-lg object-cover ring-1 ring-white/10">
											<div>
												<p class="font-medium text-white">{{ $item->menu->nama_menu }}</p>
												<p class="text-xs text-slate-500">{{ $item->menu->kategori->nama_kategori }}</p>
											</div>
										</div>
									</td>
									<td class="px-6 py-4 text-right text-sm text-slate-300">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
									<td class="px-6 py-4 text-right text-sm text-slate-300">{{ $item->jumlah }}</td>
									<td class="px-6 py-4 text-right text-sm font-semibold text-amber-400">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
								</tr>
								@if ($item->catatan_khusus)
									<tr class="bg-amber-500/5">
										<td colspan="4" class="px-6 py-2 text-sm text-amber-300"><strong>Catatan:</strong> {{ $item->catatan_khusus }}</td>
									</tr>
								@endif
							@endforeach
						</tbody>
					</table>
				</div>
			</div>

			@if ($order->pembayaran)
				<div class="glass-card rounded-2xl p-6">
					<h2 class="mb-5 text-lg font-bold text-white">Informasi Pembayaran</h2>
					<div class="grid grid-cols-2 gap-5">
						<div>
							<p class="text-[10px] font-semibold uppercase tracking-widest text-slate-500">Metode</p>
							<p class="mt-1 text-sm text-slate-300">{{ ucfirst(str_replace('_', ' ', $order->pembayaran->metode_bayar ?? 'Belum Terbayar')) }}</p>
						</div>
						<div>
							<p class="text-[10px] font-semibold uppercase tracking-widest text-slate-500">Status</p>
							<span class="badge mt-1 {{ $order->pembayaran->status_bayar === 'lunas' ? 'badge-success' : 'badge-info' }}">{{ ucfirst($order->pembayaran->status_bayar) }}</span>
						</div>
						@if ($order->pembayaran->waktu_bayar)
							<div>
								<p class="text-[10px] font-semibold uppercase tracking-widest text-slate-500">Waktu Bayar</p>
								<p class="mt-1 text-sm text-slate-300">{{ $order->pembayaran->waktu_bayar->format('d/m/Y H:i:s') }}</p>
							</div>
						@endif
					</div>
				</div>
			@endif
		</div>

		<div class="space-y-6">
			<div class="glass-card rounded-2xl p-6">
				<h3 class="mb-5 text-lg font-bold text-white">Ringkasan</h3>
				@php $subtotal = 0; foreach ($order->orderItems as $item) { $subtotal += $item->subtotal; } @endphp
				<div class="mb-4 space-y-3">
					<div class="flex justify-between text-sm"><span class="text-slate-400">Subtotal</span><span class="text-slate-200">Rp {{ number_format($subtotal, 0, ',', '.') }}</span></div>
					<div class="flex justify-between text-sm"><span class="text-slate-400">PPN (10%)</span><span class="text-slate-200">Rp {{ number_format($subtotal * 0.1, 0, ',', '.') }}</span></div>
				</div>
				<div class="border-t border-white/10 pt-4">
					<div class="flex items-center justify-between">
						<span class="font-semibold text-slate-300">Total</span>
						<span class="text-2xl font-bold text-pink-400">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</span>
					</div>
				</div>
			</div>

			<div class="glass-card space-y-3 rounded-2xl p-6">
				<h3 class="mb-3 text-lg font-bold text-white">Aksi</h3>
				@if ($order->status_order !== 'selesai')
					<form action="{{ route('order.updateStatus', $order->id_order) }}" method="POST">
						@csrf
						<select name="status_order" class="form-input mb-3">
							<option value="pending" {{ $order->status_order === 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
							<option value="lunas" {{ $order->status_order === 'lunas' ? 'selected' : '' }}>Lunas</option>
							<option value="diproses" {{ $order->status_order === 'diproses' ? 'selected' : '' }}>Sedang Diproses</option>
							<option value="selesai" {{ $order->status_order === 'selesai' ? 'selected' : '' }}>Selesai</option>
						</select>
						<button type="submit" class="btn btn-secondary w-full">Update Status</button>
					</form>
				@else
					<div class="badge badge-success w-full justify-center py-3 text-sm">✓ Pesanan Selesai</div>
				@endif
				<a href="{{ route('order.print', $order->id_order) }}" target="_blank" class="btn w-full" style="background:rgba(59,130,246,0.15);color:#60a5fa;border:1px solid rgba(59,130,246,0.2);">🖨️ Print Struk</a>
				<a href="{{ route('kasir.pesanan') }}" class="btn btn-ghost w-full">Kembali ke Dashboard</a>
			</div>
		</div>
	</div>
@endsection
