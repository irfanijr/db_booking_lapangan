<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: booking.php");
    exit;
}

$nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');
$email = trim($_POST['email'] ?? '');
$lapangan_id = intval($_POST['lapangan_id'] ?? 0);
$tgl_booking = trim($_POST['tgl_booking'] ?? '');
$jam_mulai = trim($_POST['jam_mulai'] ?? '');
$durasi = intval($_POST['durasi'] ?? 0);

if (empty($nama_lengkap) || empty($no_hp) || empty($email) || $lapangan_id <= 0 || empty($tgl_booking) || empty($jam_mulai) || $durasi <= 0) {
    $_SESSION['pesan_error'] = "Semua kolom wajib diisi dengan benar!";
    header("Location: booking.php");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['pesan_error'] = "Format email tidak valid!";
    header("Location: booking.php");
    exit;
}

$nama_safe = mysqli_real_escape_string($conn, $nama_lengkap);
$no_hp_safe = mysqli_real_escape_string($conn, $no_hp);
$email_safe = mysqli_real_escape_string($conn, $email);
$tgl_safe = mysqli_real_escape_string($conn, $tgl_booking);
$jam_safe = mysqli_real_escape_string($conn, $jam_mulai);

$cek_user = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email_safe' LIMIT 1");

if (mysqli_num_rows($cek_user) > 0) {
    $data_user = mysqli_fetch_assoc($cek_user);
    $user_id = $data_user['id'];
} else {
    $insert_user = "INSERT INTO users (nama_lengkap, no_hp, email) VALUES ('$nama_safe', '$no_hp_safe', '$email_safe')";
    if (mysqli_query($conn, $insert_user)) {
        $user_id = mysqli_insert_id($conn);
    } else {
        $_SESSION['pesan_error'] = "Gagal menyimpan data pemesan: " . mysqli_error($conn);
        header("Location: booking.php");
        exit;
    }
}

$q_lapangan = mysqli_query($conn, "SELECT harga_per_jam FROM lapangan WHERE id = $lapangan_id LIMIT 1");
if (mysqli_num_rows($q_lapangan) == 0) {
    $_SESSION['pesan_error'] = "Lapangan yang dipilih tidak ditemukan!";
    header("Location: booking.php");
    exit;
}

$data_lapangan = mysqli_fetch_assoc($q_lapangan);
$total_harga = $data_lapangan['harga_per_jam'] * $durasi;

$query_insert = "INSERT INTO bookings (lapangan_id, user_id, tgl_booking, jam_mulai, durasi, total_harga, status_pembayaran) 
                 VALUES ('$lapangan_id', '$user_id', '$tgl_safe', '$jam_safe', '$durasi', '$total_harga', 'pending')";

if (mysqli_query($conn, $query_insert)) {
    $_SESSION['pesan_sukses'] = "Booking Berhasil! Silakan cek jadwal Anda di halaman Jadwal Booking.";
    header("Location: booking.php");
    exit;
} else {
    $_SESSION['pesan_error'] = "Terjadi kesalahan saat menyimpan booking: " . mysqli_error($conn);
    header("Location: booking.php");
    exit;
}
?>