<?php
session_start();
include('../includes/functions.php');
include('../includes/config.php');
check_login_admin();

$limit = 20; // 20 siswa per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

$query = mysqli_query($conn, "SELECT * FROM siswa ORDER BY nama ASC LIMIT $start, $limit");
$total_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM siswa");
$total_data = mysqli_fetch_assoc($total_query)['total'];
$total_pages = ceil($total_data / $limit);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Kelola Siswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="/assets/css/kelola-siswa.css" />
</head>
<body>
<div class="container-flex">

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Dashboard Admin</h2>
        <a href="dashboard.php"class="list-group-item list-group-item-action">🏠 Beranda</a>
        <a href="kelola_siswa.php" class="list-group-item list-group-item-action active">👨‍🎓 Kelola Akun Siswa</a>
        <a href="kelola_kandidat.php" class="list-group-item list-group-item-action">🎯 Kelola Kandidat</a>
        <a href="setting.php" class="list-group-item list-group-item-action">⚙️ Atur Status Voting</a>
        <a href="hasil.php" class="list-group-item list-group-item-action">📊 Lihat Hasil Voting</a>
        <a href="../logout.php" class="list-group-item list-group-item-action list-group-item-danger">🚪 Logout</a>
    </div>

    <!-- Main content -->
    <main class="main-content">
        <div class="table-wrapper">
            <h2>👨‍🎓 Kelola Akun Siswa</h2>
            <a href="tambah_siswa.php" class="btn btn-primary">➕ Tambah Siswa</a>

            <table>
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Password</th>
                        <th>Status Memilih</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($siswa = mysqli_fetch_assoc($query)) { ?>
                    <tr>
                        <td><?= htmlspecialchars($siswa['nis']) ?></td>
                        <td><?= htmlspecialchars($siswa['nama']) ?></td>
                        <td><?= htmlspecialchars($siswa['kelas']) ?></td>
                        <td><?= htmlspecialchars($siswa['password']) ?></td>
                        <td><?= $siswa['sudah_memilih'] ? '✅ Sudah' : '❌ Belum' ?></td>
                        <td class="aksi">
                            <a href="edit_siswa.php?nis=<?= $siswa['nis'] ?>" class="btn btn-warning">✏️</a>
                            <a href="hapus_siswa.php?nis=<?= $siswa['nis'] ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus siswa ini?')">🗑️</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <div class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <a class="<?= ($i == $page) ? 'active' : '' ?>" href="?page=<?= $i ?>"><?= $i ?></a>
                <?php endfor; ?>
            </div>

            <a href="dashboard.php" class="btn btn-secondary">⬅️ Kembali</a>
        </div>
    </main>

</div>
</body>
</html>
