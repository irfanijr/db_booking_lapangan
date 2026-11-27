<?php
include 'koneksi.php';

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
          INNER JOIN lapangan l ON b.lapangan_id = l.id
          ORDER BY b.tgl_booking ASC, b.jam_mulai ASC";

$result = mysqli_query($conn, $query);
$daftar_booking = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Jadwal Booking Lapangan</title>
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

        .badge {
            padding: 5px 10px;
            border-radius: 4px;
            color: white;
            font-weight: bold;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <nav>
        <a href="index.php">Daftar Lapangan</a> |
        <a href="jadwal.php">Jadwal Booking</a>
    </nav>

    <h2>Jadwal Booking Lapangan</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pemesan</th>
                <th>Lapangan</th>
                <th>Tanggal</th>
                <th>Waktu Main</th>
                <th>Total Harga</th>
                <th>Status Pembayaran</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($daftar_booking)): ?>
                <?php $no = 1; ?>
                <?php foreach ($daftar_booking as $row): ?>
                    <?php
                    $jam_mulai_angka = (int) substr($row['jam_mulai'], 0, 2);
                    $jam_selesai_angka = $jam_mulai_angka + $row['durasi'];
                    $waktu_tampil = sprintf("%02d:00 - %02d:00 (%d Jam)", $jam_mulai_angka, $jam_selesai_angka, $row['durasi']);

                    $status = strtolower($row['status_pembayaran']);
                    if ($status == 'lunas') {
                        $warna_bg = '#28a745';
                        $teks_status = 'Lunas';
                    } elseif ($status == 'pending') {
                        $warna_bg = '#ffc107';
                        $teks_status = 'Pending';
                    } else {
                        $warna_bg = '#dc3545';
                        $teks_status = 'Batal';
                    }
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                        <td><?= htmlspecialchars($row['nama_lapangan']) ?></td>
                        <td><?= date('d-m-Y', strtotime($row['tgl_booking'])) ?></td>
                        <td><?= $waktu_tampil ?></td>
                        <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                        <td>
                            <span class="badge" style="background-color: <?= $warna_bg ?>;">
                                <?= $teks_status ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center;">Belum ada jadwal booking.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

</body>

</html>