<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\Hash;

// Test the hash directly
$hash = '$2y$12$2bH6raTv/mv9cQa48FDCr.SmQA3okqGVqhxJWhj6o99Mj7X/VxYra';
$password = 'password';

echo "Testing password verification:\n";
echo "Hash: " . $hash . "\n";
echo "Password: " . $password . "\n";

if (Hash::check($password, $hash)) {
    echo "SUCCESS: Password is correct!\n";
} else {
    echo "ERROR: Password is incorrect!\n";
}

// Also test with a fresh hash
$freshHash = Hash::make('password');
echo "\nFresh hash: " . $freshHash . "\n";
if (Hash::check($password, $freshHash)) {
    echo "SUCCESS: Fresh hash verification works!\n";
} else {
    echo "ERROR: Fresh hash verification failed!\n";
}