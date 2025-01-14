<?php
$host = 'localhost';
$dbname = 'probmaxcare';  // Ganti dengan nama database Anda
$username = 'root';       // Ganti dengan username database Anda
$password = '';           // Ganti dengan password database Anda jika ada

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}
?>
