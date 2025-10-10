<?php
include('../includes/config.php');

$id = $_GET['id'] ?? '';
if (!$id) {
    echo "ID tidak ditemukan.";
    exit;
}

$query = mysqli_query($conn, "SELECT * FROM poster WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "Data tidak ditemukan.";
    exit;
}

// Hapus file foto
$fotoPath = "../assets/images/" . $data['foto'];
if (file_exists($fotoPath)) {
    unlink($fotoPath);
}

// Hapus data dari database
$delete = mysqli_query($conn, "DELETE FROM poster WHERE id = '$id'");

if ($delete) {
    header("Location: kelola_kandidat.php");
    exit;
} else {
    echo "Gagal menghapus data.";
}
