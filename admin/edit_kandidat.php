<?php
session_start();
include('../includes/functions.php');
include('../includes/config.php');
check_login_admin();

// Ambil data kandidat berdasarkan ID
if (!isset($_GET['id'])) {
    header('Location: kelola_kandidat.php');
    exit();
}

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM kandidat WHERE id_kandidat = $id");
$kandidat = mysqli_fetch_assoc($query);

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama  = mysqli_real_escape_string($conn, $_POST['nama']);
    $kelas = mysqli_real_escape_string($conn, $_POST['kelas']);
    $visi  = mysqli_real_escape_string($conn, $_POST['visi']);
    $misi  = mysqli_real_escape_string($conn, $_POST['misi']);

    // Cek jika ada gambar baru diunggah
    if (!empty($_FILES['foto']['name'])) {
        $foto = $_FILES['foto']['name'];
        $tmp  = $_FILES['foto']['tmp_name'];
        move_uploaded_file($tmp, "../assets/images/$foto");

        mysqli_query($conn, "UPDATE kandidat SET nama='$nama', kelas='$kelas', visi='$visi', misi='$misi', foto='$foto' WHERE id_kandidat=$id");
    } else {
        mysqli_query($conn, "UPDATE kandidat SET nama='$nama', kelas='$kelas', visi='$visi', misi='$misi' WHERE id_kandidat=$id");
    }

    header('Location: kelola_kandidat.php?status=updated');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kandidat</title>
    <link rel="stylesheet" href="../assets/css/edit-kandidat.css">
</head>
<body>
<div class="container">
    <h2>✏️ Edit Data Kandidat</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama:</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($kandidat['nama']) ?>" required>
        </div>
        <div class="form-group">
            <label>Kelas:</label>
            <input type="text" name="kelas" value="<?= htmlspecialchars($kandidat['kelas']) ?>" required>
        </div>
        <div class="form-group">
            <label>Visi:</label>
            <textarea name="visi" required><?= htmlspecialchars($kandidat['visi']) ?></textarea>
        </div>
        <div class="form-group">
            <label>Misi:</label>
            <textarea name="misi" required><?= htmlspecialchars($kandidat['misi']) ?></textarea>
        </div>
        <div class="form-group">
            <label>Foto (opsional):</label><br>
            <img src="../assets/images/<?= $kandidat['foto'] ?>" width="100"><br><br>
            <input type="file" name="foto" accept="image/*">
        </div>
        <button type="submit" class="btn-primary">💾 Simpan Perubahan</button>
        <a href="kelola_kandidat.php" class="btn-secondary">⬅️ Batal</a>
    </form>
</div>
</body>
</html>
