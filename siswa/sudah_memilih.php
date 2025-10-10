<?php
session_start();
if (!isset($_SESSION['siswa'])) {
    header('Location: ../login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Voting Sudah Dilakukan</title>
    <link rel="stylesheet" href="../assets/css/sudah_memilih.css" />
</head>
<body>
    <div class="sukses-container">
        <div class="icon">✅</div>
        <h2>Kamu sudah melakukan voting!</h2>
        <p>Terima kasih sudah berpartisipasi dalam pemilihan Ketua OSIS.</p>
        <a href="index.php" class="btn-kembali">Kembali ke Beranda</a>
    </div>
</body>
</html>
