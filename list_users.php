<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "Daftar User:\n";
foreach (App\Models\User::all() as $u) {
    echo "ID: {$u->id} | Nama: {$u->name} | Email: {$u->email} | Role: {$u->role}\n";
}
