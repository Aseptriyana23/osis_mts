<?php 
session_start();
include('../includes/config.php');

if (!isset($_SESSION['admin'])) {
    header('Location: ../login.php');
    exit();
}

$kelasList = mysqli_query($conn, "SELECT DISTINCT kelas FROM siswa ORDER BY kelas");
$feedback = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['hapus_siswa'])) {
        $kelas = $_POST['kelas_hapus'];
    
        // Ambil semua NIS dari siswa di kelas yang ingin dihapus
        $result = mysqli_query($conn, "SELECT nis FROM siswa WHERE kelas='$kelas'");
        while ($row = mysqli_fetch_assoc($result)) {
            $nis = $row['nis'];
            // Hapus vote berdasarkan NIS tersebut
            mysqli_query($conn, "DELETE FROM vote WHERE nis='$nis'");
        }
    
        // Setelah vote dihapus, baru hapus siswa
        mysqli_query($conn, "DELETE FROM siswa WHERE kelas='$kelas'");
        $feedback = "<div class='alert success'>✅ Semua siswa kelas $kelas telah dihapus.</div>";
    }
    
    elseif (isset($_POST['reset_status'])) {
        $kelas = $_POST['kelas_reset'];
        mysqli_query($conn, "UPDATE siswa SET sudah_memilih = 0 WHERE kelas='$kelas'");
        $feedback = "<div class='alert success'>🔄 Status voting kelas $kelas berhasil direset.</div>";
    }
    elseif (isset($_POST['ubah_kelas'])) {
        $kelas_asal = $_POST['kelas_asal'];
        $kelas_tujuan = $_POST['kelas_tujuan'];
        mysqli_query($conn, "UPDATE siswa SET kelas='$kelas_tujuan' WHERE kelas='$kelas_asal'");
        $feedback = "<div class='alert success'>📚 Semua siswa dari kelas $kelas_asal telah dipindahkan ke kelas $kelas_tujuan.</div>";
    }
    elseif (isset($_POST['hapus_vote'])) {
        mysqli_query($conn, "DELETE FROM vote");
        $feedback = "<div class='alert warning'>🗑️ Semua data voting telah dihapus.</div>";
    }
    elseif (isset($_POST['reset_semua_status'])) {
        mysqli_query($conn, "UPDATE siswa SET sudah_memilih = 0");
        $feedback = "<div class='alert info'>🔄 Semua status voting siswa telah direset.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Pengaturan Sistem Voting</title>
    <link rel="stylesheet" href="/assets/css/setting.css" />
</head>
<body>

<div class="sidebar">
    <h2>Dashboard Admin</h2>
    <a href="dashboard.php">🏠 Beranda</a>
    <a href="kelola_siswa.php">👨‍🎓 Kelola Akun Siswa</a>
    <a href="kelola_kandidat.php">🎯 Kelola Kandidat</a>
    <a href="setting.php">⚙️ Atur Status Voting</a>
    <a href="hasil.php">📊 Lihat Hasil Voting</a>
    <a href="../logout.php" class="list-group-item-danger">🚪 Logout</a>
</div>

<div class="main-content">
    <h2 class="title">⚙️ Pengaturan Sistem Voting</h2>
    <?= $feedback ? "<div class='alert info'>{$feedback}</div>" : '' ?>

    <form method="post">
        <label>Hapus akun siswa berdasarkan kelas</label>
        <select name="kelas_hapus" required>
            <option value="">-- Pilih Kelas --</option>
            <?php
            mysqli_data_seek($kelasList, 0);
            while ($row = mysqli_fetch_assoc($kelasList)) {
                echo "<option value=\"" . htmlspecialchars($row['kelas']) . "\">" . htmlspecialchars($row['kelas']) . "</option>";
            }
            ?>
        </select>
        <button type="submit" name="hapus_siswa">Hapus Siswa</button>
    </form>

    <form method="post">
        <label>Reset status voting berdasarkan kelas</label>
        <select name="kelas_reset" required>
            <option value="">-- Pilih Kelas --</option>
            <?php
            mysqli_data_seek($kelasList, 0);
            while ($row = mysqli_fetch_assoc($kelasList)) {
                echo "<option value=\"" . htmlspecialchars($row['kelas']) . "\">" . htmlspecialchars($row['kelas']) . "</option>";
            }
            ?>
        </select>
        <button type="submit" name="reset_status">Reset Status</button>
    </form>

    <form method="post">
        <label>Ubah kelas siswa secara massal</label>
        <select name="kelas_asal" required>
            <option value="">-- Kelas Asal --</option>
            <?php
            mysqli_data_seek($kelasList, 0);
            while ($row = mysqli_fetch_assoc($kelasList)) {
                echo "<option value=\"" . htmlspecialchars($row['kelas']) . "\">" . htmlspecialchars($row['kelas']) . "</option>";
            }
            ?>
        </select>
        <input type="text" name="kelas_tujuan" placeholder="Contoh: 11 IPA 1" required>
        <button type="submit" name="ubah_kelas">Ubah Kelas</button>
    </form>

    <form method="post">
        <button type="submit" name="hapus_vote" onclick="return confirm('Yakin ingin menghapus semua data voting?')">🗑️ Hapus Semua Data Voting</button>
    </form>

    <form method="post">
        <button type="submit" name="reset_semua_status">🔄 Reset Semua Status Voting</button>
    </form>

    <div class="btn-back-container">
        <a href="dashboard.php" class="btn-back">🔙 Kembali ke Dashboard</a>
    </div>
</div>

</body>
</html>
