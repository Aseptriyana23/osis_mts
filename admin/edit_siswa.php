<?php
session_start();
include('../includes/functions.php');
include('../includes/config.php');
check_login_admin();

$nis_lama = $_GET['nis'] ?? '';
$pesan = "";

// Ambil data siswa berdasarkan NIS lama
$query = mysqli_query($conn, "SELECT * FROM siswa WHERE nis = '$nis_lama'");
$siswa = mysqli_fetch_assoc($query);

if (!$siswa) {
    die("❌ Siswa tidak ditemukan.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nis_baru = mysqli_real_escape_string($conn, $_POST['nis']);
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $kelas    = mysqli_real_escape_string($conn, $_POST['kelas']);
    $password = $_POST['password'];

    // Cek kalau NIS baru berbeda dan sudah ada di DB
    if ($nis_baru !== $nis_lama) {
        $cek = mysqli_query($conn, "SELECT * FROM siswa WHERE nis = '$nis_baru'");
        if (mysqli_num_rows($cek) > 0) {
            $pesan = "❌ NIS baru sudah terdaftar!";
        }
    }

    if (empty($pesan)) {
        if (!empty($password)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $update = "UPDATE siswa SET nis='$nis_baru', nama='$nama', kelas='$kelas', password='$hash' WHERE nis='$nis_lama'";
        } else {
            $update = "UPDATE siswa SET nis='$nis_baru', nama='$nama', kelas='$kelas' WHERE nis='$nis_lama'";
        }
        mysqli_query($conn, $update);
        header('Location: kelola_siswa.php?status=updated');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Edit Data Siswa</title>
<style>
    body {
        background-color: #f0f2f5;
        font-family: Arial, sans-serif;
        padding: 40px;
    }
    .container {
        background: #fff;
        max-width: 600px;
        margin: auto;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 6px 16px rgba(0,0,0,0.1);
    }
    h3 {
        margin-bottom: 24px;
        color: #333;
    }
    label {
        display: block;
        margin-bottom: 6px;
        font-weight: bold;
        color: #444;
    }
    input[type="text"] {
        width: 100%;
        padding: 10px 14px;
        margin-bottom: 16px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 16px;
    }
    .btn {
        padding: 10px 16px;
        border: none;
        border-radius: 6px;
        font-weight: bold;
        cursor: pointer;
        text-decoration: none;
        font-size: 16px;
        margin-right: 8px;
    }
    .btn-primary {
        background-color: #007bff;
        color: white;
    }
    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }
    .alert {
        margin-bottom: 16px;
        padding: 12px;
        background-color: #f8d7da;
        color: #721c24;
        border-radius: 6px;
    }
</style>
</head>
<body>
<div class="container">
    <h3>✏️ Edit Data Siswa</h3>

    <?php if ($pesan): ?>
        <div class="alert"><?= $pesan ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="nis">NIS</label>
            <input type="text" name="nis" id="nis" value="<?= htmlspecialchars($siswa['nis']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="nama">Nama</label>
            <input type="text" name="nama" id="nama" value="<?= htmlspecialchars($siswa['nama']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="kelas">Kelas</label>
            <input type="text" name="kelas" id="kelas" value="<?= htmlspecialchars($siswa['kelas']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="password">Password Baru (Kosongkan jika tidak diubah)</label>
            <input type="text" name="password" id="password" placeholder="Isi jika ingin ganti password">
        </div>

        <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
        <a href="kelola_siswa.php" class="btn btn-secondary">⬅️ Kembali</a>
    </form>
</div>
</body>
</html>
