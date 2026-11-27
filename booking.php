<?php
session_start();
include 'koneksi.php';

$query_lapangan = "SELECT id, nama_lapangan, harga_per_jam FROM lapangan";
$result_lapangan = mysqli_query($conn, $query_lapangan);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Form Booking Lapangan</title>
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

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input,
        select {
            padding: 8px;
            width: 320px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .alert {
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 4px;
            width: 320px;
            box-sizing: border-box;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>

    <nav>
        <a href="index.php">Daftar Lapangan</a> |
        <a href="jadwal.php">Jadwal Booking</a> |
        <a href="booking.php">Booking Sekarang</a>
    </nav>

    <h2>Form Booking Lapangan</h2>

    <?php if (isset($_SESSION['pesan_sukses'])): ?>
        <div class="alert alert-success">
            <?= $_SESSION['pesan_sukses']; ?>
            <?php unset($_SESSION['pesan_sukses']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['pesan_error'])): ?>
        <div class="alert alert-error">
            <?= $_SESSION['pesan_error']; ?>
            <?php unset($_SESSION['pesan_error']); ?>
        </div>
    <?php endif; ?>

    <form action="proses_booking.php" method="POST">
        <div class="form-group">
            <label for="nama_lengkap">Nama Lengkap Pemesan</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" placeholder="Masukkan nama lengkap" required>
        </div>

        <div class="form-group">
            <label for="no_hp">Nomor HP / WhatsApp</label>
            <input type="text" id="no_hp" name="no_hp" placeholder="Contoh: 081234567890" required>
        </div>

        <div class="form-group">
            <label for="email">Alamat Email</label>
            <input type="email" id="email" name="email" placeholder="Contoh: nama@email.com" required>
        </div>

        <div class="form-group">
            <label for="lapangan_id">Pilih Lapangan</label>
            <select id="lapangan_id" name="lapangan_id" required>
                <option value="">-- Pilih Lapangan --</option>
                <?php while ($row = mysqli_fetch_assoc($result_lapangan)): ?>
                    <option value="<?= $row['id'] ?>">
                        <?= htmlspecialchars($row['nama_lapangan']) ?> - Rp
                        <?= number_format($row['harga_per_jam'], 0, ',', '.') ?>/jam
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="tgl_booking">Tanggal Booking</label>
            <input type="date" id="tgl_booking" name="tgl_booking" required>
        </div>

        <div class="form-group">
            <label for="jam_mulai">Jam Mulai</label>
            <input type="time" id="jam_mulai" name="jam_mulai" required>
        </div>

        <div class="form-group">
            <label for="durasi">Durasi Sewa (Jam)</label>
            <input type="number" id="durasi" name="durasi" min="1" max="12" value="1" required>
        </div>

        <button type="submit" name="submit">Pesan Lapangan</button>
    </form>

</body>

</html>