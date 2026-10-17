<?php
require __DIR__ . '/vendor/autoload.php';
$_ENV['APP_KEY'] = 'base64:dUaIYWMPJ6ho7339YakJGTijwZkMRYCJ4Wl+5fX8rUk=';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

// Simulate authenticated santri user
$user = \App\Models\User::where('nis', '0001')->first();
auth()->setUser($user);

// Test route dispatch
$request = \Illuminate\Http\Request::create('http://127.0.0.1:8000/santri/dashboard', 'GET');
try {
    $response = $kernel->handle($request);
    echo "Status: " . $response->status() . "\n";
    if ($response->status() == 200) {
        echo "Content preview: " . substr($response->getContent(), 0, 200) . "...\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
}