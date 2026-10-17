<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
echo "view.compiled: " . app('config')->get('view.compiled') . "\n";
echo "view.cache: " . app('config')->get('view.cache') . "\n";
echo "view.relative_hash: " . app('config')->get('view.relative_hash') . "\n";
