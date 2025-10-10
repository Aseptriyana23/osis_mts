<?php
$host = 'localhost';
$user = 'root';       // Sesuaikan username DB kamu
$pass = '';           // Sesuaikan password DB kamu
$dbname = 'db_voting'; // Nama database

// Koneksi ke database
$conn = new mysqli($host, $user, $pass, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
