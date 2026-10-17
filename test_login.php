<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$_SERVER['REQUEST_METHOD'] = 'POST';
$_SERVER['REQUEST_URI'] = '/login';
$_POST['login'] = 'admin';
$_POST['password'] = 'password';

ob_start();
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);
$content = ob_get_clean();

echo $content;
?>