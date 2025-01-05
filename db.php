<?php
$host = 'localhost';  // Ganti dengan host database Anda
$user = 'root';       // Ganti dengan username database Anda
$pass = '';           // Ganti dengan password database Anda
$dbname = 'todo_app'; // Nama database yang telah dibuat

try {
    // Koneksi ke database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>
