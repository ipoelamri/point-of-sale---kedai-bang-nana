<?php
$env = [];
foreach (file(__DIR__ . '/../.env') as $line) {
    $line = trim($line);
    if ($line === '' || strpos($line, '#') === 0) continue;
    if (!strpos($line, '=')) continue;
    [$k, $v] = explode('=', $line, 2);
    $env[trim($k)] = trim($v);
}

$driver = $env['DB_CONNECTION'] ?? 'mysql';
try {
    if ($driver === 'sqlite') {
        $path = $env['DB_DATABASE'] ?? __DIR__ . '/../database/database.sqlite';
        $pdo = new PDO('sqlite:' . $path);
    } else {
        $host = $env['DB_HOST'] ?? '127.0.0.1';
        $port = $env['DB_PORT'] ?? 3306;
        $db = $env['DB_DATABASE'] ?? '';
        $user = $env['DB_USERNAME'] ?? 'root';
        $pass = $env['DB_PASSWORD'] ?? '';
        $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    }

    echo "=== DEBUG: Orders dan Pembayarans ===\n\n";

    // Check orders
    echo "ORDERS:\n";
    $stmt = $pdo->query('SELECT id_order, no_order, nama_pelanggan, total_bayar, status_order, created_at FROM orders LIMIT 10');
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($orders as $o) {
        echo "  ID: {$o['id_order']}, No: {$o['no_order']}, Nama: {$o['nama_pelanggan']}, Total: {$o['total_bayar']}, Status: {$o['status_order']}, Created: {$o['created_at']}\n";
    }

    echo "\nPEMBAYARAN:\n";
    $stmt = $pdo->query('SELECT id_pembayaran, order_id, snap_token, metode_bayar, status_bayar, waktu_bayar, created_at FROM pembayarans LIMIT 10');
    $pembayarans = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($pembayarans as $p) {
        echo "  ID: {$p['id_pembayaran']}, OrderID: {$p['order_id']}, MetodeBayar: {$p['metode_bayar']}, Status: {$p['status_bayar']}, Created: {$p['created_at']}\n";
    }

    echo "\nJOIN TEST (Orders dengan Pembayaran yang status='lunas'):\n";
    $stmt = $pdo->query("
        SELECT o.id_order, o.no_order, o.total_bayar, p.status_bayar, p.created_at as pembayaran_created
        FROM orders o
        LEFT JOIN pembayarans p ON o.id_order = p.order_id
        WHERE p.status_bayar = 'lunas'
        LIMIT 10
    ");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($results)) {
        echo "  [KOSONG] Tidak ada order dengan pembayaran status 'lunas'\n";
    } else {
        foreach ($results as $r) {
            echo "  OrderID: {$r['id_order']}, No: {$r['no_order']}, Total: {$r['total_bayar']}, PembayaranStatus: {$r['status_bayar']}\n";
        }
    }

    echo "\nALL PEMBAYARAN STATUS VALUES:\n";
    $stmt = $pdo->query('SELECT DISTINCT status_bayar FROM pembayarans');
    $statuses = $stmt->fetchAll(PDO::FETCH_COLUMN);
    foreach ($statuses as $s) {
        echo "  - '$s'\n";
    }

} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}
