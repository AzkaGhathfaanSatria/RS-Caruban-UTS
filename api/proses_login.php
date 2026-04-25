<?php
session_set_cookie_params(0, '/');
session_start();
require_once 'koneksi.php';

$email = mysqli_real_escape_string($koneksi, $_POST['email'] ?? '');
$nik   = mysqli_real_escape_string($koneksi, $_POST['nik'] ?? '');
$pass  = $_POST['password'] ?? '';

$sql = "SELECT * FROM user WHERE email='$email' AND nik='$nik' LIMIT 1";
$query = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_assoc($query);

if ($data && password_verify($pass, $data['password'])) {
    $_SESSION['login'] = true;
    $_SESSION['email'] = $data['email'];
    $_SESSION['role']  = strtolower(trim($data['role']));

    session_write_close(); // Kunci session sebelum pindah

    $target = ($_SESSION['role'] === 'admin') ? 'admin_dashboard.php' : 'dashboard.php';
    
    // Pindah halaman pakai JS (Lebih aman di Vercel)
    echo "<script>window.location.replace('$target');</script>";
    exit;
} else {
    echo "<script>alert('Login Gagal! Data tidak cocok.'); window.location.replace('../login.php?error=1');</script>";
    exit;
}