<?php
session_start();
include('../includes/functions.php');
include('../includes/config.php');
check_login_admin();

$pesan = "";

// Proses form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nis      = mysqli_real_escape_string($conn, $_POST['nis']);
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $kelas    = mysqli_real_escape_string($conn, $_POST['kelas']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // TANPA HASH

    // Cek duplikasi NIS
    $cek = mysqli_query($conn, "SELECT * FROM siswa WHERE nis = '$nis'");
    if (mysqli_num_rows($cek) > 0) {
        $pesan = "❌ NIS sudah terdaftar!";
    } else {
        // Simpan password asli ke database (TIDAK DIHASH)
        $insert = mysqli_query($conn, "INSERT INTO siswa (nis, nama, kelas, password) 
                                       VALUES ('$nis', '$nama', '$kelas', '$password')");

        if ($insert) {
            header('Location: kelola_siswa.php?status=sukses');
            exit();
        } else {
            $pesan = "❌ Gagal menambahkan data siswa.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Siswa</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        body {
            background-color: #f0f2f5;
            font-family: Arial, sans-serif;
            padding: 40px;
        }

        .form-container {
            background: #fff;
            max-width: 600px;
            margin: auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }

        h3 {
            margin-bottom: 24px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px 14px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .btn {
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            margin-right: 8px;
        }

        .btn-success {
            background-color: #28a745;
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

<div class="form-container">
    <h3>➕ Tambah Siswa</h3>

    <?php if ($pesan): ?>
        <div class="alert"><?= $pesan ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="nis">NIS</label>
        <input type="text" name="nis" id="nis" required>

        <label for="nama">Nama Lengkap</label>
        <input type="text" name="nama" id="nama" required>

        <label for="kelas">Kelas</label>
        <input type="text" name="kelas" id="kelas" required>

        <label for="password">Password (Login Siswa)</label>
        <input type="text" name="password" id="password" required>

        <button type="submit" class="btn btn-success">💾 Simpan</button>
        <a href="kelola_siswa.php" class="btn btn-secondary">⬅️ Kembali</a>
    </form>
</div>

</body>
</html>
