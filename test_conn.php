<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=sistem_presensi', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Koneksi ke MySQL XAMPP BERHASIL!\n";
    echo "Database: sistem_presensi\n";
    echo "Jumlah tabel: " . count($tables) . "\n\n";
    
    foreach ($tables as $table) {
        echo "- $table\n";
    }
    
} catch (PDOException $e) {
    echo "Koneksi GAGAL: " . $e->getMessage() . "\n";
}