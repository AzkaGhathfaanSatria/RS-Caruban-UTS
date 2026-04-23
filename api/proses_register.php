<?php
include 'koneksi.php';

$email = $_POST['email'];
$nama = $_POST['nama'];
$nik = $_POST['nik'];
$password = $_POST['password'];
$no_hp = $_POST['no_hp'];
$alamat = $_POST['alamat'];

if (strlen($nik) != 16 || !is_numeric($nik)) {
    echo "<script>alert('NIK harus 16 digit angka'); window.location='register.php';</script>";
    exit;
}

if (strlen($password) < 8 || strlen($password) > 16) {
    echo "<script>alert('Password 8-16 karakter'); window.location='register.php';</script>";
    exit;
}

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$role = 'user';

$query = "INSERT INTO user (email, nik, password, nama, no_hp, alamat, role)
VALUES ('$email', '$nik', '$password_hash', '$nama', '$no_hp', '$alamat', '$role')";

mysqli_query($koneksi, $query);

echo "<script>alert('Registrasi berhasil'); window.location='login.php';</script>";
?>