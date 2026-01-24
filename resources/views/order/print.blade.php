<!DOCTYPE html>
<html lang="id">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Struk Pesanan - {{ $order->no_order }}</title>
		<style>
			@media print {
				body {
					margin: 0;
					padding: 0;
					width: 80mm;
				}
			}

			body {
				font-family: 'Courier New', monospace;
				max-width: 80mm;
				margin: 0 auto;
				padding: 10px;
			}

			.header {
				text-align: center;
				border-bottom: 1px dashed #000;
				padding-bottom: 10px;
				margin-bottom: 10px;
			}

			.header h1 {
				margin: 0;
				font-size: 18px;
			}

			.header p {
				margin: 2px 0;
				font-size: 12px;
			}

			.order-info {
				margin-bottom: 10px;
				border-bottom: 1px dashed #000;
				padding-bottom: 10px;
			}

			.order-info-row {
				display: flex;
				justify-content: space-between;
				font-size: 12px;
				margin-bottom: 3px;
			}

			.label {
				font-weight: bold;
			}

			.items {
				margin-bottom: 10px;
				border-bottom: 1px dashed #000;
				padding-bottom: 10px;
			}

			.item {
				font-size: 12px;
				margin-bottom: 5px;
			}

			.item-name {
				font-weight: bold;
			}

			.item-detail {
				display: flex;
				justify-content: space-between;
				font-size: 11px;
				padding-left: 5px;
			}

			.total-section {
				margin-bottom: 10px;
				border-bottom: 1px dashed #000;
				padding-bottom: 10px;
			}

			.total-row {
				display: flex;
				justify-content: space-between;
				font-size: 12px;
				margin-bottom: 3px;
			}

			.total-row.grand {
				font-weight: bold;
				font-size: 14px;
				margin-top: 5px;
			}

			.footer {
				text-align: center;
				font-size: 11px;
				margin-top: 10px;
			}

			.footer p {
				margin: 2px 0;
			}

			.status-badge {
				text-align: center;
				margin: 10px 0;
				font-weight: bold;
				font-size: 12px;
			}
		</style>
	</head>

	<body>
		<!-- Header -->
		<div class="header">
			<h1>KEDAI BANG NANA</h1>
			<p>Café & Resto</p>
			<p>Jl. Contoh No. 123, Kota</p>
		</div>

		<!-- Order Info -->
		<div class="order-info">
			<div class="order-info-row">
				<span class="label">No. Pesanan:</span>
				<span>{{ $order->no_order }}</span>
			</div>
			<div class="order-info-row">
				<span class="label">Waktu:</span>
				<span>{{ $order->created_at->format('d/m/Y H:i') }}</span>
			</div>
			<div class="order-info-row">
				<span class="label">Nama:</span>
				<span>{{ substr($order->nama_pelanggan, 0, 20) }}</span>
			</div>
			<div class="order-info-row">
				<span class="label">Tipe:</span>
				<span>
					@if ($order->tipe_pesanan === 'dine-in')
						Meja {{ $order->no_meja ?? '-' }}
					@else
						Bawa
					@endif
				</span>
			</div>
		</div>

		<!-- Items -->
		<div class="items">
			@foreach ($order->orderItems as $item)
				<div class="item">
					<div class="item-name">{{ substr($item->menu->nama_menu, 0, 25) }}</div>
					<div class="item-detail">
						<span>{{ $item->jumlah }}x Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</span>
						<span>Rp{{ number_format($item->subtotal, 0, ',', '.') }}</span>
					</div>
				</div>
			@endforeach
		</div>

		<!-- Total Section -->
		<div class="total-section">
			@php
				$subtotal = 0;
				foreach ($order->orderItems as $item) {
				    $subtotal += $item->subtotal;
				}
				$ppn = $subtotal * 0.1;
				$total = $order->total_bayar;
			@endphp

			<div class="total-row">
				<span>Subtotal:</span>
				<span>Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
			</div>
			<div class="total-row">
				<span>PPN 10%:</span>
				<span>Rp{{ number_format($ppn, 0, ',', '.') }}</span>
			</div>
			<div class="total-row grand">
				<span>TOTAL:</span>
				<span>Rp{{ number_format($total, 0, ',', '.') }}</span>
			</div>

			@if ($order->pembayaran)
				<div class="total-row" style="margin-top: 5px; border-top: 1px dashed #000; padding-top: 3px;">
					<span>Metode:</span>
					<span>{{ ucfirst(str_replace('_', ' ', $order->pembayaran->metode_bayar)) }}</span>
				</div>
			@endif
		</div>

		<!-- Status -->
		<div class="status-badge">
			@if ($order->status_order === 'pending')
				MENUNGGU PEMBAYARAN
			@elseif ($order->status_order === 'lunas')
				PEMBAYARAN LUNAS
			@elseif ($order->status_order === 'diproses')
				SEDANG DIPROSES
			@else
				SELESAI
			@endif
		</div>

		<!-- Footer -->
		<div class="footer">
			<p>Terima kasih atas kunjungan Anda</p>
			<p>{{ now()->format('d/m/Y H:i:s') }}</p>
		</div>

		<script>
			window.addEventListener('load', function() {
				window.print();
			});
		</script>
	</body>

</html>
