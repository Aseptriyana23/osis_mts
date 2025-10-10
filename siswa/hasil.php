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
    <meta charset="UTF-8">
    <title>Hasil Voting</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
            padding: 40px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .hasil-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 16px rgba(0,0,0,0.08);
        }

        th, td {
            padding: 14px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        thead {
            background-color: #007bff;
            color: white;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        img.foto-kandidat {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }

        .persentase {
            font-weight: bold;
            color: #28a745;
        }
    </style>
</head>
<body>

<div class="hasil-container">
    <h2>📊 Hasil Voting Ketua OSIS</h2>

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
                <td><img src="../uploads/<?= $row['foto'] ?>" alt="<?= $row['nama'] ?>" class="foto-kandidat"></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['kelas']) ?></td>
                <td><?= $row['jumlah_suara'] ?></td>
                <td class="persentase"><?= number_format($persen, 2) ?>%</td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div style="text-align:center; margin-top:20px;">
        <strong>Total Suara Masuk: <?= $total_vote ?></strong>
    </div>
</div>

</body>
</html>
