<?php
/**
 * SIPASTOB-AB One-Time Setup Script
 *
 * INSTRUCTIONS:
 * 1. Make sure .env file is configured with correct DB credentials
 * 2. Access this file via browser: http://sipastob-ab.com/setup.php
 * 3. After successful setup, DELETE this file immediately!
 *
 * WARNING: Delete this file after use to prevent unauthorized access.
 */

define('LARAVEL_START', microtime(true));

// Security token to prevent unauthorized access
// Change this token and pass it as ?token=YOUR_TOKEN in the URL
$SETUP_TOKEN = 'sipastob-setup-2026';

if (!isset($_GET['token']) || $_GET['token'] !== $SETUP_TOKEN) {
    http_response_code(403);
    die('<h1>403 Forbidden</h1><p>Access denied. Provide valid token.</p>');
}

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SIPASTOB-AB Setup</title>
    <style>
        body { font-family: monospace; background: #0f172a; color: #e2e8f0; padding: 40px; max-width: 800px; margin: 0 auto; }
        h1 { color: #3b82f6; }
        .step { background: #1e293b; border-radius: 8px; padding: 16px; margin: 12px 0; }
        .step h3 { margin: 0 0 8px 0; color: #94a3b8; font-size: 13px; text-transform: uppercase; }
        .ok { color: #10b981; }
        .err { color: #ef4444; }
        .warn { color: #f59e0b; }
        pre { margin: 8px 0 0 0; white-space: pre-wrap; font-size: 13px; }
        .done { background: #064e3b; border: 1px solid #10b981; border-radius: 8px; padding: 20px; margin-top: 20px; }
        .warning-box { background: #7f1d1d; border: 1px solid #ef4444; border-radius: 8px; padding: 20px; margin-top: 20px; }
    </style>
</head>
<body>
<h1>SIPASTOB-AB &mdash; Setup</h1>

<?php

function runStep(string $title, callable $fn): bool {
    echo "<div class='step'><h3>{$title}</h3><pre>";
    ob_start();
    try {
        $result = $fn();
        $output = ob_get_clean();
        if ($output) echo htmlspecialchars($output);
        echo "<span class='ok'>&#10003; Selesai</span>";
        echo "</pre></div>";
        return true;
    } catch (\Throwable $e) {
        $output = ob_get_clean();
        if ($output) echo htmlspecialchars($output);
        echo "<span class='err'>&#10007; Error: " . htmlspecialchars($e->getMessage()) . "</span>";
        echo "</pre></div>";
        return false;
    }
}

// Step 1: Check DB connection
runStep('1. Test Koneksi Database', function () {
    try {
        \Illuminate\Support\Facades\DB::connection()->getPdo();
        $dbName = \Illuminate\Support\Facades\DB::connection()->getDatabaseName();
        echo "Terhubung ke database: {$dbName}\n";
    } catch (\Exception $e) {
        throw new \Exception("Tidak bisa konek ke database: " . $e->getMessage());
    }
});

// Step 2: Generate App Key
runStep('2. Generate App Key', function () {
    $currentKey = config('app.key');
    if ($currentKey && strlen($currentKey) > 10) {
        echo "App key sudah ada, skip.\n";
        return;
    }
    \Illuminate\Support\Facades\Artisan::call('key:generate', ['--force' => true]);
    echo \Illuminate\Support\Facades\Artisan::output();
});

// Step 3: Run migrations
runStep('3. Jalankan Migrations', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    echo \Illuminate\Support\Facades\Artisan::output();
});

// Step 4: Run seeders
runStep('4. Jalankan Seeders (Admin + Data Obat)', function () {
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
    echo \Illuminate\Support\Facades\Artisan::output();
});

// Step 5: Clear & cache config
runStep('5. Optimasi Cache', function () {
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    echo "config:clear\n";
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    echo "view:clear\n";
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    echo "route:clear\n";
    echo "Selesai.\n";
});

// Step 6: Verify data
runStep('6. Verifikasi Data', function () {
    $userCount = \App\Models\User::count();
    $medCount = \App\Models\Medicine::count();
    echo "Users: {$userCount}\n";
    echo "Medicines: {$medCount}\n";
    if ($userCount === 0) throw new \Exception("Tidak ada user! Seeder gagal.");
    if ($medCount === 0) throw new \Exception("Tidak ada data obat! Seeder gagal.");
});

?>

<div class="done">
    <strong class="ok">&#10003; Setup Selesai!</strong><br><br>
    Sekarang kamu bisa login di: <a href="http://sipastob-ab.com/login" style="color:#3b82f6;">http://sipastob-ab.com/login</a><br><br>
    <strong>Email:</strong> admin@sipastob-ab.com<br>
    <strong>Password:</strong> S!p4st0b@2026#AB
</div>

<div class="warning-box">
    <strong class="err">&#9888; PENTING: Hapus file ini sekarang!</strong><br><br>
    Pergi ke File Manager cPanel &rarr; <code>public_html/setup.php</code> &rarr; Delete.<br>
    File ini berbahaya jika dibiarkan karena bisa diakses siapa saja.
</div>

</body>
</html>
