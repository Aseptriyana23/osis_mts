<?php
session_start();
include('../includes/functions.php');
include('../includes/config.php');

// Cek jika admin sudah login
if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit();
}

// Ambil data admin dari database
$username = $_SESSION['admin'];
$query = "SELECT * FROM admin WHERE username = '$username'";
$result = $conn->query($query);
$admin = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin 🛠️</title>
    <link rel="stylesheet" href="/assets/css/dashboard-admin.css">
</head>
<body>
    <div class="sidebar">
        <h2>Dashboard Admin</h2>
        <a href="dashboard.php"class="list-group-item list-group-item-action">🏠 Beranda</a>
        <a href="kelola_siswa.php" class="list-group-item list-group-item-action">👨‍🎓 Kelola Akun Siswa</a>
            <a href="kelola_kandidat.php" class="list-group-item list-group-item-action">🎯 Kelola Kandidat</a>
            <a href="setting.php" class="list-group-item list-group-item-action">⚙️ Atur Status Voting</a>
            <a href="hasil.php" class="list-group-item list-group-item-action">📊 Lihat Hasil Voting</a>
            <a href="../logout.php" class="list-group-item list-group-item-action list-group-item-danger">🚪 Logout</a>
    </div>

    <div class="main-content">
        <div class="dashboard-card">
            <h2>Halo, <?= htmlspecialchars($admin['username']); ?> 👋</h2>
            <p>Selamat datang di dashboard admin silahkan lakukan perubahan disini.</p>
        </div>
    </div>
</body>
</html>