<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

// Admin
$admin = User::where('email', 'admin@presensi.com')->first();
if (!$admin) {
    $admin = User::create([
        'name' => 'Ustadz Admin',
        'email' => 'admin@presensi.com',
        'password' => bcrypt('password'),
        'role' => 'admin',
        'username' => 'admin',
    ]);
    echo "Created admin\n";
} else {
    $admin->username = 'admin';
    $admin->password = bcrypt('password');
    $admin->save();
    echo "Updated admin\n";
}

// Petugas
$petugas = User::where('email', 'petugas@presensi.com')->first();
if (!$petugas) {
    $petugas = User::create([
        'name' => 'Petugas Santri',
        'email' => 'petugas@presensi.com',
        'password' => bcrypt('password'),
        'role' => 'petugas',
        'username' => 'petugas_presensi',
    ]);
    echo "Created petugas\n";
} else {
    $petugas->username = 'petugas_presensi';
    $petugas->password = bcrypt('password');
    $petugas->save();
    echo "Updated petugas\n";
}
?>