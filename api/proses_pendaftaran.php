<?php
session_start();
require_once('koneksi.php');

$isLogin = isset($_SESSION['login']) || (isset($_COOKIE['user_login']) && $_COOKIE['user_login'] === 'true');
$email   = $_SESSION['email'] ?? $_COOKIE['user_email'] ?? '';

if (!$isLogin || empty($email)) {
    echo "<script>alert('Sesi berakhir, silakan login kembali.'); window.location='login.php';</script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
    $nik    = mysqli_real_escape_string($conn, $_POST['nik']);
    $no_hp  = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $poli   = mysqli_real_escape_string($conn, $_POST['poli']);
    $dokter = mysqli_real_escape_string($conn, $_POST['dokter']);
    
    $nama_asli = $_SESSION['nama_akun'] ?? '';
    $nik_asli  = $_SESSION['nik_akun'] ?? '';

    if (strtolower($nama) !== strtolower($nama_asli) || $nik !== $nik_asli) {
        echo "<script>alert('Nama atau NIK tidak sesuai dengan data akun Anda! Pastikan mengisi sesuai identitas saat registrasi.'); window.history.back();</script>";
        exit();
    }

    $query = "INSERT INTO pasien (email, nama, nik, no_hp, poli, dokter, tanggal)
              VALUES ('$email', '$nama', '$nik', '$no_hp', '$poli', '$dokter', NOW())";

    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Pendaftaran Berhasil! Silakan cek riwayat kunjungan Anda.'); 
                window.location='riwayat.php';
              </script>";
    } else {
        echo "Database Error: " . mysqli_error($conn);
    }
} else {
    header("Location: pendaftaran.php");
    exit();
}
?>