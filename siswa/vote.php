<?php
session_start();
include('../includes/config.php');

if (!isset($_SESSION['siswa'])) {
    header('Location: ../login.php');
    exit();
}

$nis = $_SESSION['siswa'];

// Cek apakah siswa sudah memilih
$cek = mysqli_query($conn, "SELECT sudah_memilih FROM siswa WHERE nis='$nis'");
$data = mysqli_fetch_assoc($cek);

if ($data['sudah_memilih']) {
    header('Location: sudah_memilih.php');
    exit();
}


// Ambil data kandidat
$kandidat = mysqli_query($conn, "SELECT * FROM kandidat");

// Proses saat memilih
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_kandidat'])) {
    $id_kandidat = $_POST['id_kandidat'];

    // Simpan ke tabel vote
    mysqli_query($conn, "INSERT INTO vote (nis, id_kandidat) VALUES ('$nis', '$id_kandidat')");

    // Update status sudah_memilih
    mysqli_query($conn, "UPDATE siswa SET sudah_memilih = 1 WHERE nis = '$nis'");

    header("Location: sukses.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Vote Sekarang</title>
    <link rel="stylesheet" href="/assets/css/vote.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f9;
            padding: 30px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .kandidat-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .kartu {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            width: 280px;
            text-align: center;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .konten-atas {
            flex-grow: 1;
        }

        .kartu img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .kartu h3 {
            margin: 10px 0 5px;
        }

        .kartu p {
            font-size: 14px;
            color: #555;
        }

        .kartu form {
            margin-top: 15px;
        }

        .kartu button {
            background-color: #007bff;
            color: white;
            padding: 8px 14px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .kartu button:hover {
            background-color: #0056b3;
        }

        .btn-kembali {
            background-color: #6c757d;
            color: white;
            padding: 10px 18px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
        }

        .btn-kembali:hover {
            background-color: #5a6268;
        }

        .kartu form button {
            width: 100%;
        }

        .no-urut {
    background-color: #1e40af;  /* Navy blue yang lebih gelap */
    color: #fff;
    font-size: 28px;
    font-weight: 700;
    text-align: center;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    line-height: 50px; /* supaya teks center vertikal */
    margin: 0 auto 15px auto; /* tengah dan kasih jarak bawah */
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    user-select: none; /* biar gak kepilih pas klik */
}



    </style>
</head>
<body>

<h2>Silahkan Pilih Kandidat Ketua OSIS</h2>

<div class="kandidat-container">
    <?php while ($row = mysqli_fetch_assoc($kandidat)) { ?>
        <div class="kartu">
        <div class="no-urut"></div>
            <div class="konten-atas">
                <img src="<?= (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/assets/images/' . $row['foto'] ?>" 
                     alt="<?= htmlspecialchars($row['nama']) ?>" 
                     class="foto-kandidat">

                <h3><?= htmlspecialchars($row['nama']) ?></h3>
                <p><strong>Kelas:</strong> <?= htmlspecialchars($row['kelas']) ?></p>
            </div>
            <form method="post" onsubmit="return confirm('Yakin ingin memilih <?= htmlspecialchars($row['nama']) ?>?')">
                <input type="hidden" name="id_kandidat" value="<?= $row['id_kandidat'] ?>">
                <button type="submit">Pilih</button>
            </form>
        </div>
    <?php } ?>
</div>

<div style="text-align: center; margin-top: 40px;">
    <a href="index.php" class="btn-kembali">⬅️ Kembali ke Beranda</a>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cards = document.querySelectorAll('.kartu');
        cards.forEach((card, index) => {
            const noUrut = card.querySelector('.no-urut');
            noUrut.textContent = (index + 1).toString().padStart(2, '0');
        });
    });
</script>


</body>
</html>
