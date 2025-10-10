<?php
session_start();
include('../includes/config.php');

// Ambil total jumlah pemilih
$total = mysqli_query($conn, "SELECT COUNT(*) as total_vote FROM vote");
$total_vote = mysqli_fetch_assoc($total)['total_vote'];

// Ambil data hasil vote per kandidat
$hasil = mysqli_query($conn, "
    SELECT k.id_kandidat, k.nama, k.kelas, k.foto, COUNT(v.id_vote) as jumlah_suara
    FROM kandidat k
    LEFT JOIN vote v ON k.id_kandidat = v.id_kandidat
    GROUP BY k.id_kandidat
    ORDER BY jumlah_suara DESC
");


?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Hasil Voting</title>
    <link rel="stylesheet" href="../assets/css/hasil-voting.css" />
</head>
<body>

<div class="sidebar">
    <h2>Dashboard Admin</h2>
    <a href="dashboard.php">🏠 Beranda</a>
    <a href="kelola_siswa.php">👨‍🎓 Kelola Akun Siswa</a>
    <a href="kelola_kandidat.php">🎯 Kelola Kandidat</a>
    <a href="setting.php">⚙️ Atur Status Voting</a>
    <a href="hasil.php" class="active">📊 Lihat Hasil Voting</a>
    <a href="../logout.php" class="list-group-item-danger">🚪 Logout</a>
</div>

<div class="main-content">
    <div class="hasil-container">
        <h2>Hasil SUARA Voting Ketua OSIS PERIODE 2025-2026</h2>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Jumlah Suara</th>
                        <th>Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($hasil)) {
                        $persen = $total_vote > 0 ? ($row['jumlah_suara'] / $total_vote * 100) : 0;
                    ?>
                    <tr>
                        <td>
                            <img src="<?= (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/assets/images/' . $row['foto'] ?>" 
                                 alt="<?= htmlspecialchars($row['nama']) ?>" 
                                 class="foto-kandidat">
                        </td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['kelas']) ?></td>
                        <td><?= $row['jumlah_suara'] ?></td>
                        <td class="persentase"><?= number_format($persen, 2) ?>%</td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="footer">
            <p><strong>Total Suara Masuk:</strong> <?= $total_vote ?></p>
            <div class="footer-buttons">
                <a href="../admin/dashboard.php" class="btn-back">🔙 Kembali ke Dashboard</a>
                <button onclick="window.print()" class="btn-print">🖨️ Cetak PDF</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>
