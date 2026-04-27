<?php
require_once(dirname(__FILE__) . '/koneksi.php');

if (!isset($koneksi) && isset($conn)) {
    $koneksi = $conn;
}

if (!$koneksi) {
    die("Koneksi gagal: Variabel database tidak ditemukan. Cek isi koneksi.php kamu.");
}

$email    = mysqli_real_escape_string($koneksi, $_POST['email']);
$nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
$nik      = mysqli_real_escape_string($koneksi, $_POST['nik']);
$password = $_POST['password']; 
$no_hp    = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
$alamat   = mysqli_real_escape_string($koneksi, $_POST['alamat']);
$role     = 'user';

if (strlen($nik) != 16) {
    echo "<script>alert('NIK harus 16 digit!'); window.history.back();</script>";
    exit;
}

if (strlen($password) < 8 || strlen($password) > 16) {
    echo "<script>alert('Password harus antara 8-16 karakter!'); window.history.back();</script>";
    exit;
}

$cek = mysqli_query($koneksi, "SELECT email FROM user WHERE email = '$email'");
if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Email sudah terdaftar!'); window.history.back();</script>";
    exit;
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$query = "INSERT INTO user (email, nik, password, nama, no_hp, alamat, role)
          VALUES ('$email', '$nik', '$password_hash', '$nama', '$no_hp', '$alamat', '$role')";

if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Registrasi berhasil!'); window.location='login.php';</script>";
} else {
    echo "Gagal: " . mysqli_error($koneksi);
}
?>