<!DOCTYPE html>
<html lang="id">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Laporan Pelanggan Terbaik - Kedai Bang Nana</title>
		<style>
			* {
				margin: 0;
				padding: 0;
				box-sizing: border-box;
			}

			body {
				font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
				background: white;
				color: #333;
				line-height: 1.6;
			}

			@page {
				size: A4;
				margin: 20mm;
			}

			@media print {
				body {
					background: white;
				}

				button {
					display: none;
				}
			}

			.container {
				max-width: 210mm;
				margin: 0 auto;
				padding: 20px;
			}

			header {
				text-align: center;
				margin-bottom: 30px;
				border-bottom: 3px solid #dc0080;
				padding-bottom: 20px;
			}

			.logo {
				font-size: 28px;
				font-weight: bold;
				color: #333;
				margin-bottom: 10px;
			}

			.logo .brand {
				color: #dc0080;
				font-style: italic;
			}

			.report-title {
				font-size: 24px;
				font-weight: bold;
				color: #dc0080;
				margin: 20px 0 10px 0;
			}

			.report-info {
				font-size: 12px;
				color: #666;
				margin-bottom: 20px;
			}

			.summary-section {
				margin: 30px 0;
				padding: 20px;
				background: #f8f9fa;
				border-left: 4px solid #dc0080;
				border-radius: 4px;
			}

			.summary-title {
				font-size: 16px;
				font-weight: bold;
				color: #dc0080;
				margin-bottom: 15px;
			}

			.summary-grid {
				display: grid;
				grid-template-columns: 1fr 1fr;
				gap: 15px;
				margin-bottom: 15px;
			}

			.summary-item {
				padding: 12px;
				background: white;
				border: 1px solid #ddd;
				border-radius: 4px;
			}

			.summary-label {
				font-size: 12px;
				color: #666;
				margin-bottom: 5px;
			}

			.summary-value {
				font-size: 18px;
				font-weight: bold;
				color: #333;
			}

			table {
				width: 100%;
				border-collapse: collapse;
				margin: 20px 0;
				font-size: 12px;
			}

			table thead {
				background: #dc0080;
				color: white;
			}

			table th {
				padding: 12px;
				text-align: left;
				font-weight: bold;
				border: 1px solid #ddd;
			}

			table td {
				padding: 10px 12px;
				border: 1px solid #ddd;
			}

			table tbody tr:nth-child(odd) {
				background: #f8f9fa;
			}

			table tbody tr:hover {
				background: #f0e6eb;
			}

			.rank-badge {
				display: inline-block;
				min-width: 30px;
				height: 30px;
				line-height: 30px;
				text-align: center;
				border-radius: 50%;
				font-weight: bold;
				color: white;
				font-size: 14px;
			}

			.rank-1 {
				background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%);
			}

			.rank-2 {
				background: linear-gradient(135deg, #C0C0C0 0%, #A9A9A9 100%);
			}

			.rank-3 {
				background: linear-gradient(135deg, #CD7F32 0%, #B87333 100%);
			}

			.rank-other {
				background: #999;
			}

			.text-right {
				text-align: right;
			}

			.text-center {
				text-align: center;
			}

			.currency {
				font-weight: bold;
				color: #27ae60;
			}

			footer {
				margin-top: 30px;
				padding-top: 20px;
				border-top: 1px solid #ddd;
				text-align: center;
				font-size: 11px;
				color: #666;
			}

			.print-button {
				display: inline-block;
				margin: 20px 0;
				padding: 10px 20px;
				background: #dc0080;
				color: white;
				border: none;
				border-radius: 4px;
				cursor: pointer;
				font-size: 14px;
				font-weight: bold;
			}

			.print-button:hover {
				background: #c20670;
			}

			.no-data {
				padding: 40px;
				text-align: center;
				color: #999;
				font-size: 14px;
			}

			@media (max-width: 768px) {
				.container {
					padding: 10px;
				}

				.summary-grid {
					grid-template-columns: 1fr;
				}

				table {
					font-size: 11px;
				}

				table th,
				table td {
					padding: 8px;
				}
			}
		</style>
	</head>

	<body>
		<div class="container">
			<!-- Header -->
			<header>
				<div class="logo">
					Kedai Bang <span class="brand">Nana</span>
				</div>
				<div class="report-title">📊 Laporan Pelanggan Terbaik</div>
				<div class="report-info">
					<p>Tanggal Laporan: {{ now()->format('d F Y H:i:s') }}</p>
					<p>Periode: {{ $periodLabel }} | Batasan: Top {{ $topLimit }}</p>
				</div>
			</header>

			<!-- Summary Section -->
			@if ($summaryStats)
				<div class="summary-section">
					<div class="summary-title">📈 Ringkasan Data</div>
					<div class="summary-grid">
						<div class="summary-item">
							<div class="summary-label">👥 Pelanggan Unik</div>
							<div class="summary-value">{{ number_format($summaryStats->total_unique_customers ?? 0) }}</div>
						</div>
						<div class="summary-item">
							<div class="summary-label">📋 Total Transaksi</div>
							<div class="summary-value">{{ number_format($summaryStats->total_transactions ?? 0) }}</div>
						</div>
						<div class="summary-item">
							<div class="summary-label">💰 Total Pendapatan</div>
							<div class="summary-value currency">Rp {{ number_format($summaryStats->total_revenue ?? 0, 0, ',', '.') }}</div>
						</div>
						<div class="summary-item">
							<div class="summary-label">📊 Rata-rata Transaksi</div>
							<div class="summary-value currency">Rp {{ number_format($summaryStats->avg_transaction ?? 0, 0, ',', '.') }}
							</div>
						</div>
					</div>
				</div>
			@endif

			<!-- Main Table -->
			@if ($bestCustomers->count() > 0)
				<table>
					<thead>
						<tr>
							<th width="8%">🏆 Peringkat</th>
							<th width="35%">Nama Pelanggan</th>
							<th width="12%" class="text-center">📋 Pesanan</th>
							<th width="20%" class="text-right">💰 Total Pengeluaran</th>
							<th width="15%" class="text-right">📊 Rata-rata</th>
							<th width="10%" class="text-center">🕐 Terakhir</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($bestCustomers as $index => $customer)
							<tr>
								<td class="text-center">
									@if ($customer->rank == 1)
										<span class="rank-badge rank-1">🥇</span>
									@elseif($customer->rank == 2)
										<span class="rank-badge rank-2">🥈</span>
									@elseif($customer->rank == 3)
										<span class="rank-badge rank-3">🥉</span>
									@else
										<span class="rank-badge rank-other">{{ $customer->rank }}</span>
									@endif
								</td>
								<td><strong>{{ $customer->nama_pelanggan }}</strong></td>
								<td class="text-center">{{ $customer->total_orders }} x</td>
								<td class="currency text-right">Rp {{ number_format($customer->total_spending, 0, ',', '.') }}</td>
								<td class="text-right">Rp {{ number_format($customer->avg_spending, 0, ',', '.') }}</td>
								<td class="text-center">{{ $customer->last_order_date->format('d/m/Y') }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			@else
				<div class="no-data">
					📭 Tidak ada data pelanggan untuk periode ini
				</div>
			@endif

			<!-- Button -->
			<div style="text-align: center; margin: 30px 0;">
				<button class="print-button" onclick="window.print()">🖨️ Cetak/Simpan sebagai PDF</button>
			</div>

			<!-- Footer -->
			<footer>
				<p>Laporan ini digenerate secara otomatis dari Sistem POS Kedai Bang Nana</p>
				<p>© {{ now()->year }} - Kedai Bang Nana. Semua hak dilindungi.</p>
			</footer>
		</div>
	</body>

</html>
