@extends('layouts.app')

@section('title', 'Detail Pesanan - ' . $order->no_order)

@section('content')
	<div class="mb-6 flex items-center justify-between">
		<div>
			<h1 class="text-3xl font-bold text-slate-800">Detail Pesanan</h1>
			<p class="mt-1 text-slate-600">{{ $order->no_order }}</p>
		</div>
		<a href="{{ route('kasir.pesanan') }}" class="font-medium text-amber-600 hover:text-amber-800">
			← Kembali
		</a>
	</div>

	<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
		<!-- Main Content -->
		<div class="space-y-6 lg:col-span-2">
			<!-- Order Summary -->
			<div class="rounded-xl bg-white p-6 shadow-sm">
				<h2 class="mb-4 text-xl font-semibold text-slate-800">Informasi Pesanan</h2>

				<div class="grid grid-cols-2 gap-4">
					<div>
						<p class="text-sm font-semibold text-slate-600">No. Pesanan</p>
						<p class="text-lg font-bold text-slate-800">{{ $order->no_order }}</p>
					</div>

					<div>
						<p class="text-sm font-semibold text-slate-600">Waktu</p>
						<p class="text-slate-800">{{ $order->created_at->format('d/m/Y H:i:s') }}</p>
					</div>

					<div>
						<p class="text-sm font-semibold text-slate-600">Nama Pelanggan</p>
						<p class="text-lg font-bold text-slate-800">{{ $order->nama_pelanggan }}</p>
					</div>

					<div>
						<p class="text-sm font-semibold text-slate-600">Tipe Pesanan</p>
						<p class="text-slate-800">
							@if ($order->tipe_pesanan === 'dine-in')
								Makan di Tempat (Meja {{ $order->no_meja ?? '-' }})
							@else
								Bawa Pulang
							@endif
						</p>
					</div>

					<div>
						<p class="text-sm font-semibold text-slate-600">Status Pesanan</p>
						<span
							class="{{ $order->status_order === 'pending' ? 'bg-blue-100 text-blue-800' : ($order->status_order === 'lunas' ? 'bg-emerald-100 text-emerald-800' : ($order->status_order === 'diproses' ? 'bg-orange-100 text-orange-800' : 'bg-slate-100 text-slate-800')) }} inline-block rounded-full px-3 py-1 text-sm font-semibold">
							{{ ucfirst(str_replace('_', ' ', $order->status_order)) }}
						</span>
					</div>

					<div>
						<p class="text-sm font-semibold text-slate-600">Kasir</p>
						<p class="text-slate-800">{{ $order->kasir->username ?? 'Self-Service' }}</p>
					</div>
				</div>
			</div>

			<!-- Items -->
			<div class="rounded-xl bg-white p-6 shadow-sm">
				<h2 class="mb-4 text-xl font-semibold text-slate-800">Daftar Item</h2>

				<div class="overflow-x-auto">
					<table class="w-full">
						<thead class="bg-slate-50">
							<tr>
								<th class="px-4 py-2 text-left text-sm font-semibold text-slate-700">Menu</th>
								<th class="px-4 py-2 text-right text-sm font-semibold text-slate-700">Harga</th>
								<th class="px-4 py-2 text-right text-sm font-semibold text-slate-700">Jumlah</th>
								<th class="px-4 py-2 text-right text-sm font-semibold text-slate-700">Subtotal</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($order->orderItems as $item)
								<tr class="border-b border-slate-200">
									<td class="px-4 py-3">
										<div class="flex items-center gap-3">
											<img src="{{ asset('storage/' . $item->menu->foto) }}" alt="{{ $item->menu->nama_menu }}"
												class="h-10 w-10 rounded object-cover">
											<div>
												<p class="font-medium text-slate-800">{{ $item->menu->nama_menu }}</p>
												<p class="text-xs text-slate-600">{{ $item->menu->kategori->nama_kategori }}</p>
											</div>
										</div>
									</td>
									<td class="px-4 py-3 text-right text-slate-800">
										Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
									</td>
									<td class="px-4 py-3 text-right text-slate-800">{{ $item->jumlah }}</td>
									<td class="px-4 py-3 text-right font-semibold text-amber-600">
										Rp {{ number_format($item->subtotal, 0, ',', '.') }}
									</td>
								</tr>

								@if ($item->catatan_khusus)
									<tr class="bg-yellow-50">
										<td colspan="4" class="px-4 py-2 text-sm text-yellow-800">
											<strong>Catatan:</strong> {{ $item->catatan_khusus }}
										</td>
									</tr>
								@endif
							@endforeach
						</tbody>
					</table>
				</div>
			</div>

			<!-- Payment Info -->
			@if ($order->pembayaran)
				<div class="rounded-xl bg-white p-6 shadow-sm">
					<h2 class="mb-4 text-xl font-semibold text-slate-800">Informasi Pembayaran</h2>

					<div class="grid grid-cols-2 gap-4">
						<div>
							<p class="text-sm font-semibold text-slate-600">Metode Pembayaran</p>
							<p class="text-slate-800">
								{{ ucfirst(str_replace('_', ' ', $order->pembayaran->metode_bayar ?? 'Belum Terbayar')) }}</p>
						</div>

						<div>
							<p class="text-sm font-semibold text-slate-600">Status Pembayaran</p>
							<span
								class="{{ $order->pembayaran->status_bayar === 'lunas' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }} inline-block rounded-full px-3 py-1 text-sm font-semibold">
								{{ ucfirst($order->pembayaran->status_bayar) }}
							</span>
						</div>

						@if ($order->pembayaran->waktu_bayar)
							<div>
								<p class="text-sm font-semibold text-slate-600">Waktu Pembayaran</p>
								<p class="text-slate-800">{{ $order->pembayaran->waktu_bayar->format('d/m/Y H:i:s') }}</p>
							</div>
						@endif
					</div>
				</div>
			@endif
		</div>

		<!-- Sidebar -->
		<div class="space-y-6">
			<!-- Total Summary -->
			<div class="rounded-xl border border-amber-200 bg-amber-50 p-6 shadow-sm">
				<h3 class="mb-4 text-lg font-semibold text-slate-800">Ringkasan</h3>

				<div class="mb-4 space-y-2">
					@php
						$subtotal = 0;
						foreach ($order->orderItems as $item) {
						    $subtotal += $item->subtotal;
						}
					@endphp

					<div class="flex justify-between text-slate-700">
						<span>Subtotal:</span>
						<span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
					</div>
					<div class="flex justify-between text-slate-700">
						<span>PPN (10%):</span>
						<span>Rp {{ number_format($subtotal * 0.1, 0, ',', '.') }}</span>
					</div>
				</div>

				<div class="border-t-2 border-amber-200 pt-3">
					<div class="flex items-center justify-between">
						<span class="text-lg font-semibold text-slate-800">Total:</span>
						<span class="text-2xl font-bold text-amber-600">
							Rp {{ number_format($order->total_bayar, 0, ',', '.') }}
						</span>
					</div>
				</div>
			</div>

			<!-- Actions -->
			<div class="space-y-3 rounded-xl bg-white p-6 shadow-sm">
				<h3 class="mb-4 text-lg font-semibold text-slate-800">Aksi</h3>

				@if ($order->status_order !== 'selesai')
					<form action="{{ route('order.updateStatus', $order->id_order) }}" method="POST">
						@csrf
						<select name="status_order" class="mb-3 w-full rounded-lg border border-slate-300 px-4 py-2">
							<option value="pending" {{ $order->status_order === 'pending' ? 'selected' : '' }}>
								Menunggu Pembayaran
							</option>
							<option value="lunas" {{ $order->status_order === 'lunas' ? 'selected' : '' }}>
								Lunas
							</option>
							<option value="diproses" {{ $order->status_order === 'diproses' ? 'selected' : '' }}>
								Sedang Diproses
							</option>
							<option value="selesai" {{ $order->status_order === 'selesai' ? 'selected' : '' }}>
								Selesai
							</option>
						</select>
						<button type="submit"
							class="w-full rounded-lg bg-amber-500 py-2 font-semibold text-white transition hover:bg-amber-600">
							Update Status
						</button>
					</form>
				@else
					<div class="w-full rounded-lg bg-emerald-100 py-2 text-center font-semibold text-emerald-800">
						✓ Pesanan Selesai
					</div>
				@endif

				<a href="{{ route('order.print', $order->id_order) }}" target="_blank"
					class="block w-full rounded-lg bg-blue-500 py-2 text-center font-semibold text-white transition hover:bg-blue-600">
					🖨️ Print Struk
				</a>

				<a href="{{ route('kasir.pesanan') }}"
					class="block w-full rounded-lg bg-slate-200 py-2 text-center font-semibold text-slate-800 transition hover:bg-slate-300">
					Kembali ke Dashboard
				</a>
			</div>
		</div>
	</div>
@endsection
