<?php
session_start();
require_once('koneksi.php');

$isLogin = isset($_SESSION['login']) || (isset($_COOKIE['user_login']) && $_COOKIE['user_login'] === 'true');
$email_asli = $_SESSION['email'] ?? $_COOKIE['user_email'] ?? '';

if (!$isLogin) { exit("Akses Ditolak"); }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_input = mysqli_real_escape_string($conn, trim($_POST['nama']));
    $nik_input  = mysqli_real_escape_string($conn, trim($_POST['nik']));
    $no_hp      = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $poli       = mysqli_real_escape_string($conn, $_POST['poli']);
    $dokter     = mysqli_real_escape_string($conn, $_POST['dokter']);

    // Data dari Akun Login
    $nama_akun = $_SESSION['nama_akun'] ?? $_COOKIE['user_nama'] ?? '';
    $nik_akun  = $_SESSION['nik_akun'] ?? $_COOKIE['user_nik'] ?? '';

    // Validasi Double-Lock
    if (strtolower($nama_input) !== strtolower($nama_akun) || $nik_input !== $nik_akun) {
        echo "<script>alert('Gagal! Nama dan NIK harus sesuai akun Anda.'); window.history.back();</script>";
        exit();
    }

    $query = "INSERT INTO pasien (email, nama, nik, no_hp, poli, dokter, tanggal) VALUES ('$email_asli', '$nama_input', '$nik_input', '$no_hp', '$poli', '$dokter', NOW())";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Pendaftaran Berhasil!'); window.location='riwayat.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>