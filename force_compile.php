<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\View;

// This triggers real HTTP-like view rendering through Laravel
Artisan::call('view:clear');
echo "view:clear: " . Artisan::output() . "\n";

// Force compile by rendering the view (simulates HTTP request)
$compiler = app('blade.compiler');
$path = resource_path('views/admin/dashboard.blade.php');
\Log::info('Compiling admin.dashboard from path: ' . $path);
$compiler->compile($path);

// Save debug to file
file_put_contents(storage_path('app/compile_check.txt'), 
    date('Y-m-d H:i:s') . " compiled to: " . $compiler->getCompiledPath($path) . "\n", 
    FILE_APPEND);

echo "Done. Check storage/logs/laravel.log\n";
