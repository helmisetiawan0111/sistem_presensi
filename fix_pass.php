<?php
$pdo = new PDO('mysql:host=127.0.0.1;port=3306;dbname=sistem_presensi', 'root', '');

$newHash = '$2y$12$ZQSJc2m3JR.nhzGBJvOzZe1xZWyT2yc/5qjMxPYsLKkt1grVa9I9W';

$pdo->exec("UPDATE users SET password = '$newHash' WHERE email = 'admin@presensi.com'");
echo "Password diupdate!\n";

$verify = $pdo->query("SELECT password FROM users WHERE email = 'admin@presensi.com'")->fetch();
echo "Valid: " . (password_verify('password', $verify['password']) ? 'YES' : 'NO') . "\n";