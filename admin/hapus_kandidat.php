<?php
session_start();
include('../includes/functions.php');
include('../includes/config.php');
check_login_admin();

$id_kandidat = $_GET['id'] ?? '';

if ($id_kandidat) {
    // Ambil data kandidat sebelum dihapus untuk mengecek apakah foto ada
    $result = mysqli_query($conn, "SELECT * FROM kandidat WHERE id_kandidat = '$id_kandidat'");
    $kandidat = mysqli_fetch_assoc($result);
    
    if ($kandidat) {
        // Hapus file foto kandidat dari server
        $foto_path = "../assets/images/" . $kandidat['foto'];
        if (file_exists($foto_path)) {
            unlink($foto_path);  // Menghapus file foto dari folder
        }
        
        // Hapus kandidat dari database
        mysqli_query($conn, "DELETE FROM kandidat WHERE id_kandidat = '$id_kandidat'");
        
        // Redirect ke halaman kelola_kandidat.php setelah berhasil
        header('Location: kelola_kandidat.php?status=deleted');
        exit();
    }
}

header('Location: kelola_kandidat.php?status=error');
exit();
?>
