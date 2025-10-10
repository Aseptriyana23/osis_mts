<?php
include('../includes/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $foto = $_FILES['foto']['name'];
    $tmp = $_FILES['foto']['tmp_name'];

    $target = "../assets/images/" . $foto;

    // Upload file
    if (move_uploaded_file($tmp, $target)) {
        $query = "INSERT INTO poster (id, foto) VALUES ('$id', '$foto')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            header("Location: kelola_kandidat.php");
            exit;
        } else {
            echo "Gagal menyimpan ke database.";
        }
    } else {
        echo "Gagal upload gambar.";
    }
}
?>


<head>
    <meta charset="UTF-8">
    <title>Tambah Poster</title>
    <link rel="stylesheet" href="../assets/css/tambah-poster.css">
</head>
<form action="" method="POST" enctype="multipart/form-data">
    <label>ID Poster (wajib unik):</label><br>
    <input type="text" name="id" required><br><br>

    <label>Upload Gambar:</label><br>
    <input type="file" name="foto" accept="image/*" required><br><br>

    <button type="submit">Simpan</button>
    <a href="dashboard.php" class="btn btn-secondary">⬅️ Kembali</a>
</form>
