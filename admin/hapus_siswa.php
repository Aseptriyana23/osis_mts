<?php
session_start();
include('../includes/functions.php');
include('../includes/config.php');
check_login_admin();

$nis = $_GET['nis'] ?? '';

if ($nis) {
    // Cek dulu apakah siswa pernah voting
    $cek_vote = mysqli_query($conn, "SELECT * FROM vote WHERE nis = '$nis'");
    if (mysqli_num_rows($cek_vote) > 0) {
        // Jika sudah voting, hapus juga dari tabel vote
        mysqli_query($conn, "DELETE FROM vote WHERE nis = '$nis'");
    }

    // Hapus dari tabel siswa
    mysqli_query($conn, "DELETE FROM siswa WHERE nis = '$nis'");
}

header('Location: kelola_siswa.php?status=deleted');
exit();
?>
