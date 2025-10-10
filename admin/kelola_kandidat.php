<?php
session_start();
include('../includes/functions.php');
include('../includes/config.php');
check_login_admin();

$result_kandidat = mysqli_query($conn, "SELECT * FROM kandidat ORDER BY id_kandidat ASC");
$result_poster = mysqli_query($conn, "SELECT * FROM poster ORDER BY id ASC");
?>


<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Kelola Kandidat</title>
<link rel="stylesheet" href="../assets/css/kelola-kandidat.css" />
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

<div class="container">
    <h3>🧑‍💼 Kelola Kandidat</h3>

    <a href="tambah_kandidat.php" class="btn btn-success">➕ Tambah Kandidat</a>
    <a href="dashboard.php" class="btn btn-secondary">⬅️ Kembali</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Foto</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Visi</th>
                <th>Misi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = mysqli_fetch_assoc($result_kandidat)) { ?>
            <tr>
                <td data-label="ID"><?= $row['id_kandidat'] ?></td>
                <td data-label="Foto"><img src="../assets/images/<?= htmlspecialchars($row['foto']) ?>" width="60" height="60" alt="Foto Kandidat"></td>
                <td data-label="Nama"><?= htmlspecialchars($row['nama']) ?></td>
                <td data-label="Kelas"><?= htmlspecialchars($row['kelas']) ?></td>
                <td data-label="Visi"><?= nl2br(htmlspecialchars($row['visi'])) ?></td>
                <td data-label="Misi"><?= nl2br(htmlspecialchars($row['misi'])) ?></td>
                <td data-label="Aksi">
                    <a href="edit_kandidat.php?id=<?= $row['id_kandidat'] ?>" class="btn btn-primary">✏️ Edit</a>
                    <a href="hapus_kandidat.php?id=<?= $row['id_kandidat'] ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus kandidat ini?')">🗑️ Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <h3>🖼️ Kelola Poster</h3>

<a href="edit_poster.php" class="btn btn-success">➕ Tambah Poster</a>
    <table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($result_poster)) { ?>
        <tr>
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><img src="../assets/images/<?= htmlspecialchars($row['foto']) ?>" width="80" alt="Poster"></td>
            <td>
                <a href="edit_poster.php?id=<?= urlencode($row['id']) ?>" class="btn btn-primary">✏️ Edit</a>
                <a href="hapus_poster.php?id=<?= urlencode($row['id']) ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus gambar ini?')">🗑️ Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</div>
</body>
</html>
