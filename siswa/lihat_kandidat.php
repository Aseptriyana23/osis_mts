<?php
session_start();
include('../includes/functions.php');
include('../includes/config.php');
check_login_siswa(); // Pastikan ada function ini

$result = mysqli_query($conn, "SELECT * FROM kandidat");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lihat Kandidat</title>
    <link rel="stylesheet" href="../assets/css/lihat-kandidat.css">
</head>
<body>
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
        <div class="container">
            <h3>Daftar Kandidat Pemilihan Osis</h3>

            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="card">
                    <img src="../assets/images/<?= $row['foto'] ?>" alt="Foto Kandidat">
                    <div class="card-body">
                        <h4><?= htmlspecialchars($row['nama']) ?> (<?= htmlspecialchars($row['id_kandidat']) ?>)</h4>
                        <p><strong>Visi:</strong><br><?= nl2br(htmlspecialchars($row['visi'])) ?></p>
                        <p><strong>Misi:</strong><br><?= nl2br(htmlspecialchars($row['misi'])) ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>

</body>
</html>
