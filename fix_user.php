<?php
require __DIR__.'/vendor/autoload.php';
 = require __DIR__.'/bootstrap/app.php';
->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Find the santri with nis 001
 = App\Models\Santri::where('nis', '001')->first();

if (!) {
    echo 'ERROR: No santri found with nis 001';
    exit(1);
}

echo 'Found santri: ID=' . ->id . ', Nama=' . ->nama . PHP_EOL;

// Find the user with nis 001 (the orphan record)
 = App\Models\User::where('nis', '001')->first();

if (!) {
    echo 'ERROR: No user found with nis 001';
    exit(1);
}

echo 'Found user: ID=' . ->id . ', Name=' . ->name . ', Role=' . ->role . PHP_EOL;

// Update the user with correct data
->name = ->nama;
->role = 'santri';
->password = Hash::make(->nis);
->santri_id = ->id;
// must_change_password should remain true for new santri
// email and username can stay null
->save();

echo 'User updated successfully!' . PHP_EOL;
echo 'New values:';
echo '  Name: ' . ->name . PHP_EOL;
echo '  Role: ' . ->role . PHP_EOL;
echo '  Password is hash: ' . (->password ? 'yes' : 'no') . PHP_EOL;
echo '  Santri ID: ' . ->santri_id . PHP_EOL;
