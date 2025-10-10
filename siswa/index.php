<?php
session_start();
include('../includes/functions.php');
include('../includes/config.php');

check_login_siswa();

if (!isset($_SESSION['siswa'])) {
    // Kalau belum login atau session tidak ada, redirect login
    header('Location: ../login.php');
    exit;
}

$nis = $_SESSION['siswa'];
// Gunakan procedural style
$query = "SELECT * FROM siswa WHERE nis = '$nis'";
$result = mysqli_query($conn, $query);
if (!$result) {
    die('Query Error: ' . mysqli_error($conn));
}
$siswa = mysqli_fetch_assoc($result);

$poster_result = mysqli_query($conn, "SELECT * FROM poster ORDER BY id ASC");
if (!$poster_result) {
    die('Query Error: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard Siswa</title>
    <link rel="stylesheet" href="/assets/css/index-siswa.css" />
</head>
<body>
    <div class="sidebar">
        <h2>Pilketos</h2>
        <ul>
            <li><a href="index.php">🏠 Beranda</a></li>
            <li><a href="lihat_kandidat.php">👀 Lihat Kandidat</a></li>
            <li><a href="vote.php">🗳️ Voting Sekarang</a></li>
            <li><a href="../logout.php" class="logout">🚪 Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="dashboard-card">
            <h2>Halo, <?= htmlspecialchars($siswa['nama']); ?> 👋</h2>
            <p>Selamat datang di portal Pilketos. Silakan pilih menu di sebelah kiri untuk melihat kandidat atau melakukan voting.</p>
        </div>

        <!-- Poster Kandidat -->
        <div class="poster-container">
    <?php while($row = mysqli_fetch_assoc($poster_result)) { ?>
        <div class="poster-card">
            <img src="/assets/images/<?= htmlspecialchars($row['foto']); ?>" alt="Poster Kandidat" />
            <div class="poster-caption">Kandidat <?= htmlspecialchars($row['id']); ?></div>
        </div>
    <?php } ?>
</div>
    </div>
</body>
</html>
