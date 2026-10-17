<?php
require __DIR__.'/vendor/autoload.php';
 = require __DIR__.'/bootstrap/app.php';
->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
 = App\Models\User::where('username', '001')->first();
if () {
    echo 'User found with username 001: ' . json_encode(->toArray());
} else {
    echo 'User not found with username 001';
}
 = App\Models\User::where('nis', '001')->first();
if () {
    echo 'User found with nis 001: ' . json_encode(->toArray());
} else {
    echo 'User not found with nis 001';
}
