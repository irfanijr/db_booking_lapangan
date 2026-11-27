<?php
include 'koneksi.php';

$query = "SELECT * FROM lapangan";
$result = mysqli_query($conn, $query);

$daftar_lapangan = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Lapangan - Booking Online</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        nav {
            margin-bottom: 20px;
        }

        nav a {
            margin-right: 15px;
            text-decoration: none;
            font-weight: bold;
            color: #0066cc;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <nav>
        <a href="index.php">Daftar Lapangan</a> |
        <a href="jadwal.php">Jadwal Booking</a>
    </nav>

    <h2>Daftar Lapangan Tersedia</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lapangan</th>
                <th>Lokasi</th>
                <th>Harga per Jam</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($daftar_lapangan)): ?>
                <?php $no = 1; ?>
                <?php foreach ($daftar_lapangan as $lapangan): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($lapangan['nama_lapangan']) ?></td>
                        <td><?= htmlspecialchars($lapangan['lokasi']) ?></td>
                        <td>Rp <?= number_format($lapangan['harga_per_jam'], 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center;">Belum ada data lapangan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>