<?php
session_start();
include('../includes/functions.php');
include('../includes/config.php');
check_login_admin();

$pesan = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kandidat = intval($_POST['id_kandidat']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $kelas = mysqli_real_escape_string($conn, $_POST['kelas']);
    $visi = mysqli_real_escape_string($conn, $_POST['visi']);
    $misi = mysqli_real_escape_string($conn, $_POST['misi']);

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['foto']['type'], $allowed_types)) {
            $pesan = "❌ File foto harus berupa JPG, PNG, atau GIF.";
        } else {
            $upload_dir = '../assets/images/';
            $foto_name = uniqid() . '_' . basename($_FILES['foto']['name']);
            $upload_file = $upload_dir . $foto_name;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $upload_file)) {
                $sql = "INSERT INTO kandidat (id_kandidat, nama, kelas, foto, visi, misi, total_suara)
                        VALUES ($id_kandidat, '$nama', '$kelas', '$foto_name', '$visi', '$misi', 0)";

                if (mysqli_query($conn, $sql)) {
                    header('Location: kelola_kandidat.php?status=sukses');
                    exit();
                } else {
                    $pesan = "❌ Gagal menambah kandidat: " . mysqli_error($conn);
                }
            } else {
                $pesan = "❌ Gagal mengupload foto.";
            }
        }
    } else {
        $pesan = "❌ Foto wajib diupload.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>➕ Tambah Kandidat</title>
    <link rel="stylesheet" href="/assets/css/tambah_kandidat.css" />
</head>
<body>
<div class="container">
    <h3>➕ Tambah Kandidat</h3>
    <?php if ($pesan): ?>
        <div class="alert"><?= htmlspecialchars($pesan) ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" novalidate>
        <label for="id_kandidat">ID Kandidat:</label>
        <input type="number" name="id_kandidat" id="id_kandidat" required min="1" />

        <label for="nama">Nama:</label>
        <input type="text" name="nama" id="nama" required maxlength="100" />

        <label for="kelas">Kelas:</label>
        <input type="text" name="kelas" id="kelas" maxlength="20" />

        <label for="foto">Foto:</label>
        <input type="file" name="foto" id="foto" accept="image/*" required />

        <label for="visi">Visi:</label>
        <textarea name="visi" id="visi" rows="4" required></textarea>

        <label for="misi">Misi:</label>
        <textarea name="misi" id="misi" rows="4" required></textarea>

        <button type="submit">💾 Simpan</button>
        <a href="kelola_kandidat.php">⬅️ Kembali</a>
    </form>
</div>
</body>
</html>
