<?php
require 'koneksi.php';

$keyword = isset($_GET['cari']) ? mysqli_real_escape_string($conn, $_GET['cari']) : '';

$query = "SELECT 
            b.id,
            u.nama_lengkap,
            l.nama_lapangan,
            b.tgl_booking,
            b.jam_mulai,
            b.durasi,
            b.total_harga,
            b.status_pembayaran
          FROM bookings b
          INNER JOIN users u ON b.user_id = u.id
          INNER JOIN lapangan l ON b.lapangan_id = l.id";

if (!empty($keyword)) {
    $query .= " WHERE u.nama_lengkap LIKE '%$keyword%' 
                OR l.nama_lapangan LIKE '%$keyword%'";
}

$query .= " ORDER BY b.tgl_booking DESC, b.jam_mulai ASC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Admin - Data Booking Lapangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .btn {
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            border-radius: 3px;
            font-size: 13px;
        }

        .btn-edit {
            background-color: #f0ad4e;
        }

        .btn-hapus {
            background-color: #d9534f;
        }

        .search-box {
            margin-bottom: 15px;
        }

        input[type="text"] {
            padding: 6px;
            width: 250px;
        }

        button {
            padding: 6px 12px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <h2>Dashboard Admin - Daftar Booking Lapangan</h2>

    <form method="GET" action="" class="search-box">
        <input type="text" name="cari" placeholder="Cari nama pemesan atau lapangan..."
            value="<?= htmlspecialchars($keyword) ?>">
        <button type="submit">Cari</button>
        <?php if (!empty($keyword)): ?>
            <a href="admin.php" style="margin-left: 10px;">Reset</a>
        <?php endif; ?>
    </form>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pemesan</th>
                <th>Lapangan</th>
                <th>Tanggal</th>
                <th>Jam Mulai</th>
                <th>Durasi</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php $no = 1;
                while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                        <td><?= htmlspecialchars($row['nama_lapangan']) ?></td>
                        <td><?= $row['tgl_booking'] ?></td>
                        <td><?= substr($row['jam_mulai'], 0, 5) ?></td>
                        <td><?= $row['durasi'] ?> Jam</td>
                        <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                        <td><strong><?= strtoupper($row['status_pembayaran']) ?></strong></td>
                        <td>
                            <a href="edit_booking.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
                            <a href="hapus_booking.php?id=<?= $row['id'] ?>" class="btn btn-hapus"
                                onclick="return confirm('Yakin ingin menghapus data booking milik <?= htmlspecialchars($row['nama_lengkap']) ?>?')">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" style="text-align: center;">Data booking tidak ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>