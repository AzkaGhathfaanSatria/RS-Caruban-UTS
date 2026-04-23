<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['email'])) {
    die("Akses ditolak. Silakan login terlebih dahulu.");
}

$email  = $_SESSION['email']; 
$nama   = mysqli_real_escape_string($conn, $_POST['nama']);
$nik    = mysqli_real_escape_string($conn, $_POST['nik']);
$no_hp  = mysqli_real_escape_string($conn, $_POST['no_hp']);
$poli   = mysqli_real_escape_string($conn, $_POST['poli']);
$dokter = mysqli_real_escape_string($conn, $_POST['dokter']);

$query = "INSERT INTO pasien (email, nama, nik, no_hp, poli, dokter, tanggal)
          VALUES ('$email', '$nama', '$nik', '$no_hp', '$poli', '$dokter', NOW())";

if (mysqli_query($conn, $query)) {
    echo "<script>alert('Pendaftaran berhasil!'); window.location='riwayat.php';</script>";
} else {
    echo "Gagal menyimpan data: " . mysqli_error($conn);
}
?>