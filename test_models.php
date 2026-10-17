<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=sistem_presensi', 'root', '');
    
    echo "=== Testing Models ===\n";
    
    // Test Santri
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM santo");
    $santri = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Santri count: " . $santri['count'] . "\n";
    
    // Test Absensi
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM absensi");
    $absensi = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Absensi count: " . $absensi['count'] . "\n";
    
    // Test JamPelajaran
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM jam_pelajaran");
    $jam = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "JamPelajaran count: " . $jam['count'] . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}