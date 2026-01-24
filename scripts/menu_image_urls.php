<?php
$env = [];
foreach (file(__DIR__ . '/../.env') as $line) {
    $line = trim($line);
    if ($line === '' || strpos($line, '#') === 0) continue;
    if (!strpos($line, '=')) continue;
    [$k, $v] = explode('=', $line, 2);
    $env[trim($k)] = trim($v);
}
$driver = $env['DB_CONNECTION'] ?? $env['DB_DRIVER'] ?? 'mysql';
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
    $stmt = $pdo->query('SELECT id_menu, nama_menu, foto FROM menus ORDER BY id_menu DESC LIMIT 10');
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $r) {
        $storagePath = __DIR__ . '/../public/storage/' . $r['foto'];
        $uploadsPath = __DIR__ . '/../public/uploads/' . $r['foto'];
        if (file_exists($storagePath)) {
            $src = '/storage/' . $r['foto'];
        } elseif (file_exists($uploadsPath)) {
            $src = '/uploads/' . $r['foto'];
        } else {
            $src = '/storage/fotos/default.jpg';
        }
        echo $r['id_menu'] . ' | ' . $r['nama_menu'] . ' | ' . $r['foto'] . ' => ' . $src . PHP_EOL;
    }
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}
