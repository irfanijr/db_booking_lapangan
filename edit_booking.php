<?php
require 'koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: admin.php");
    exit;
}

$id = intval($_GET['id']);


if (isset($_POST['submit'])) {
    $lapangan_id = intval($_POST['lapangan_id']);
    $user_id = intval($_POST['user_id']);
    $tgl_booking = mysqli_real_escape_string($conn, $_POST['tgl_booking']);
    $jam_mulai = mysqli_real_escape_string($conn, $_POST['jam_mulai']);
    $durasi = intval($_POST['durasi']);
    $status_pembayaran = mysqli_real_escape_string($conn, $_POST['status_pembayaran']);

    $q_lapangan = mysqli_query($conn, "SELECT harga_per_jam FROM lapangan WHERE id = $lapangan_id");
    $d_lapangan = mysqli_fetch_assoc($q_lapangan);
    $total_harga = $d_lapangan['harga_per_jam'] * $durasi;

    $update_query = "UPDATE bookings SET 
                        lapangan_id = '$lapangan_id',
                        user_id = '$user_id',
                        tgl_booking = '$tgl_booking',
                        jam_mulai = '$jam_mulai',
                        durasi = '$durasi',
                        total_harga = '$total_harga',
                        status_pembayaran = '$status_pembayaran'
                     WHERE id = $id";

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Data booking berhasil diperbarui!'); window.location='admin.php';</script>";
        exit;
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($conn);
    }
}

$query_booking = mysqli_query($conn, "SELECT * FROM bookings WHERE id = $id");
$data = mysqli_fetch_assoc($query_booking);

if (!$data) {
    echo "Data tidak ditemukan!";
    exit;
}

$users = mysqli_query($conn, "SELECT id, nama_lengkap FROM users");
$lapangan = mysqli_query($conn, "SELECT id, nama_lapangan, harga_per_jam FROM lapangan");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Data Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .form-group {
            margin-bottom: 12px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input,
        select {
            padding: 8px;
            width: 300px;
        }

        button {
            padding: 8px 15px;
            background-color: #5cb85c;
            color: white;
            border: none;
            cursor: pointer;
        }

        a {
            margin-left: 10px;
            text-decoration: none;
            color: #333;
        }
    </style>
</head>

<body>

    <h2>Edit Data Booking #<?= $data['id'] ?></h2>

    <form method="POST" action="">
        <div class="form-group">
            <label>Pemesan (User)</label>
            <select name="user_id" required>
                <?php while ($u = mysqli_fetch_assoc($users)): ?>
                    <option value="<?= $u['id'] ?>" <?= ($u['id'] == $data['user_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($u['nama_lengkap']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Lapangan</label>
            <select name="lapangan_id" required>
                <?php while ($l = mysqli_fetch_assoc($lapangan)): ?>
                    <option value="<?= $l['id'] ?>" <?= ($l['id'] == $data['lapangan_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($l['nama_lapangan']) ?> (Rp
                        <?= number_format($l['harga_per_jam'], 0, ',', '.') ?>/jam)
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Tanggal Booking</label>
            <input type="date" name="tgl_booking" value="<?= $data['tgl_booking'] ?>" required>
        </div>

        <div class="form-group">
            <label>Jam Mulai</label>
            <input type="time" name="jam_mulai" value="<?= $data['jam_mulai'] ?>" required>
        </div>

        <div class="form-group">
            <label>Durasi (Jam)</label>
            <input type="number" name="durasi" min="1" max="12" value="<?= $data['durasi'] ?>" required>
        </div>

        <div class="form-group">
            <label>Status Pembayaran</label>
            <select name="status_pembayaran" required>
                <option value="pending" <?= ($data['status_pembayaran'] == 'pending') ? 'selected' : '' ?>>Pending</option>
                <option value="lunas" <?= ($data['status_pembayaran'] == 'lunas') ? 'selected' : '' ?>>Lunas</option>
                <option value="batal" <?= ($data['status_pembayaran'] == 'batal') ? 'selected' : '' ?>>Batal</option>
            </select>
        </div>

        <button type="submit" name="submit">Simpan Perubahan</button>
        <a href="admin.php">Batal</a>
    </form>

</body>

</html>