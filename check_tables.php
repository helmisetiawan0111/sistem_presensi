<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=sistem_presensi', 'root', '');
$tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
print_r($tables);