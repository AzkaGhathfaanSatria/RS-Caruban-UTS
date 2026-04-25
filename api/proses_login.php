<?php
session_start();
include 'koneksi.php';

$email = $_POST['email'] ?? '';
$nik = $_POST['nik'] ?? '';
$password = $_POST['password'] ?? '';

if ($email == '' || $nik == '' || $password == '') {
    echo "<script>alert('Data harus lengkap'); window.location='/index.html';</script>";
    exit;
}

// Proteksi SQL Injection sederhana
$email = mysqli_real_escape_string($koneksi, $email);
$nik = mysqli_real_escape_string($koneksi, $nik);

$query = mysqli_query($koneksi, "SELECT * FROM user WHERE email='$email' AND nik='$nik'");
$data = mysqli_fetch_assoc($query);

if ($data) {
    if (password_verify($password, $data['password'])) {
        // SET SESSION
        $_SESSION['login'] = true;
        $_SESSION['email'] = $data['email'];
        $_SESSION['role'] = strtolower(trim($data['role']));

        // KRITIKAL: Paksa simpan session sebelum redirect
        session_write_close();

        // Redirect pakai JS lebih aman di lingkungan serverless/Vercel
        $target = ($_SESSION['role'] == 'admin') ? '/api/admin_dashboard.php' : '/api/dashboard.php';
        echo "<script>window.location.href='$target';</script>";
        exit;
    } else {
        echo "<script>alert('Password salah'); window.location='/index.html';</script>";
        exit;
    }
} else {
    echo "<script>alert('User tidak ditemukan'); window.location='/index.html';</script>";
    exit;
}
?>