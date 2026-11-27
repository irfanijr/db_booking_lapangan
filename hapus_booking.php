<?php
require 'koneksi.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

  
    $query = "DELETE FROM bookings WHERE id = $id";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data booking berhasil dihapus!'); window.location='admin.php';</script>";
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }
} else {
    header("Location: admin.php");
}
?>