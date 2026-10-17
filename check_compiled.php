<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\View;
use Carbon\Carbon;

// Force fresh compile of admin/dashboard
View::replaceNamespace('admin', resource_path('views/admin'));

// Manually trigger compile of admin.dashboard view
$compiler = app('blade.compiler');
$path = resource_path('views/admin/dashboard.blade.php');
$compiler->compile($path);

$compiled = $compiler->getCompiledPath($path);
\Log::info('ADMIN_DASHBOARD compiled to: ' . $compiled);
echo "ADMIN_DASHBOARD compiled to: $compiled\n";

if (file_exists($compiled)) {
    echo "File EXISTS. Size: " . filesize($compiled) . " bytes\n";
    // Show lines around $totalTdk
    $lines = file($compiled);
    foreach ($lines as $i => $line) {
        if (strpos($line, 'totalTdk') !== false || strpos($line, 'semua') !== false) {
            echo ($i+1) . ': ' . trim($line) . "\n";
        }
    }
} else {
    echo "File DOES NOT EXIST\n";
}

// List all files in the compiled directory
$dir = $compiler->getCompiledPath(resource_path('views/admin/dashboard.blade.php'));
$compDir = dirname($dir);
echo "\nContents of compiled directory ($compDir):\n";
@file_put_contents($compDir . '/_debug_', 'test ' . date('Y-m-d H:i:s'));
$files = glob($compDir . '/*');
foreach ($files as $f) {
    echo basename($f) . "\n";
}
