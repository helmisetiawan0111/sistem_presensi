<?php

// Initialize Laravel
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

// Make facades available
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Now test
use App\Models\User;
use Illuminate\Support\Facades\Hash;

echo "=== DEBUG LOGIN ===\n\n";

// Check if user exists
$user = User::where('email', 'petugas@presensi.com')->first();

if (!$user) {
    echo "ERROR: User not found!\n";
    exit;
}

echo "User found:\n";
echo "  ID: " . $user->id . "\n";
echo "  Name: " . $user->name . "\n";
echo "  Email: " . $user->email . "\n";
echo "  Role: " . $user->role . "\n";
echo "  Password hash: " . $user->password . "\n\n";

// Test password
$password = 'password';
echo "Testing password: '$password'\n";

if (Hash::check($password, $user->password)) {
    echo "SUCCESS: Password matches!\n";
} else {
    echo "ERROR: Password does not match!\n";
    
    // Let's also try to see what hash we get from the password
    $newHash = Hash::make($password);
    echo "New hash for 'password': " . $newHash . "\n";
    echo "Are they the same? " . ($user->password === $newHash ? 'Yes' : 'No') . "\n";
}

echo "\n=== END DEBUG ===\n";