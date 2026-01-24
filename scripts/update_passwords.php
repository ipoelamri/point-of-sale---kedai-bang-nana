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

    // Hash password menggunakan bcrypt
    $hashedPassword = password_hash('12345678', PASSWORD_BCRYPT);

    // Update semua users dengan password yang sudah di-hash
    $stmt = $pdo->prepare('UPDATE users SET password = ? WHERE role IN (?, ?, ?)');
    $stmt->execute([$hashedPassword, 'admin', 'kasir', 'pemilik']);

    echo "✓ Password berhasil di-update!\n";
    echo "Gunakan password: 12345678\n\n";

    // Tampilkan user list
    $stmt = $pdo->query('SELECT id_user, username, role FROM users');
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Users yang bisa login:\n";
    foreach ($rows as $r) {
        echo "- Username: {$r['username']}, Password: 12345678, Role: {$r['role']}\n";
    }
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}
