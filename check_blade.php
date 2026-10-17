<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$blade = app('blade.compiler');
$compiled = $blade->getCompiledPath(resource_path('views/admin/dashboard.blade.php'));

echo "compiled path: $compiled\n";

if (file_exists($compiled)) {
    echo "COMPILED EXISTS size=" . filesize($compiled) . "\n";
    $lines = file($compiled);
    foreach ($lines as $i => $line) {
        if (strpos($line, 'totalTdk') !== false || strpos($line, 'recMap') !== false) {
            echo ($i+1) . ': ' . trim($line) . "\n";
        }
    }
} else {
    echo "COMPILED NOT FOUND\n";
}
