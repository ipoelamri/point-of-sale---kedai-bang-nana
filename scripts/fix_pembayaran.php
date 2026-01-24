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

    // Set orders dengan total > 0 menjadi 'lunas' untuk testing
    $stmt = $pdo->prepare("
        UPDATE pembayarans p
        INNER JOIN orders o ON p.order_id = o.id_order
        SET p.status_bayar = 'lunas', p.waktu_bayar = NOW()
        WHERE o.total_bayar > 0
    ");
    $stmt->execute();
    
    echo "✓ Pembayaran diupdate menjadi 'lunas' untuk testing\n\n";

    // Show updated data
    echo "PEMBAYARAN UPDATED:\n";
    $stmt = $pdo->query('SELECT id_pembayaran, order_id, status_bayar, waktu_bayar FROM pembayarans');
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $r) {
        echo "  OrderID: {$r['order_id']}, Status: {$r['status_bayar']}, WaktuBayar: {$r['waktu_bayar']}\n";
    }

    echo "\nJOIN TEST (Orders dengan Pembayaran yang status='lunas'):\n";
    $stmt = $pdo->query("
        SELECT o.id_order, o.no_order, o.total_bayar, p.status_bayar
        FROM orders o
        LEFT JOIN pembayarans p ON o.id_order = p.order_id
        WHERE p.status_bayar = 'lunas'
    ");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "  Total: " . count($results) . " orders\n";
    $totalRevenue = 0;
    foreach ($results as $r) {
        echo "  OrderID: {$r['id_order']}, Total: {$r['total_bayar']}, Status: {$r['status_bayar']}\n";
        $totalRevenue += $r['total_bayar'];
    }
    echo "  Total Revenue: Rp " . number_format($totalRevenue, 0, ',', '.') . "\n";

} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}
