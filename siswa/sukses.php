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
    <title>Voting Sukses</title>
    <link rel="stylesheet" href="../assets/css/sukses.css" />
</head>
<body>
    <div class="sukses-container">
        <div class="icon">✅</div>
        <h2>Terima kasih telah memilih!</h2>
        <p>Suara kamu sudah kami terima dengan baik.</p>
        <a href="index.php" class="btn-kembali">Kembali ke Beranda</a>
    </div>
</body>
</html>
