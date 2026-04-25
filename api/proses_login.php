<?php
session_start();
// Menggunakan dirname agar path file koneksi selalu benar di server Vercel
require_once(dirname(__FILE__) . '/koneksi.php');

// Ambil data dari POST
$email = $_POST['email'] ?? '';
$nik = $_POST['nik'] ?? '';
$password = $_POST['password'] ?? '';

// Menggunakan Prepared Statements untuk keamanan (Mencegah SQL Injection)
$stmt = mysqli_prepare($conn, "SELECT * FROM user WHERE email=? AND nik=?");
mysqli_stmt_bind_param($stmt, "ss", $email, $nik);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if ($data) {
    // Verifikasi password
    if (password_verify($password, $data['password'])) {
        $_SESSION['login'] = true;
        $_SESSION['role'] = $data['role'];
        $_SESSION['email'] = $data['email'];

        if ($data['role'] == 'admin') {
            header("Location: admin_dashboard.php");
        } else {
            header("Location: dashboard.php");
        }
        exit;
    } else {
        echo "<script>alert('Password salah'); window.location='login.php';</script>";
    }
} else {
    echo "<script>alert('User tidak ditemukan atau NIK/Email salah'); window.location='login.php';</script>";
}
?>