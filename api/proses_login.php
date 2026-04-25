<?php
ob_start();
session_start();
require_once(dirname(__FILE__) . '/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $nik = mysqli_real_escape_string($conn, $_POST['nik']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE email='$email' AND nik='$nik' LIMIT 1";
    $query = mysqli_query($conn, $sql);

    if ($query && mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);

        if (password_verify($password, $data['password'])) {
            // 1. Simpan di Session (untuk lokal/server biasa)
            $_SESSION['login'] = true;
            $_SESSION['role']  = $data['role'];
            $_SESSION['email'] = $data['email'];

            // 2. Simpan di Cookie (Cadangan untuk Vercel - Berlaku 1 hari)
            setcookie('user_login', 'true', time() + (86400 * 1), "/");
            setcookie('user_role', $data['role'], time() + (86400 * 1), "/");
            setcookie('user_email', $data['email'], time() + (86400 * 1), "/");

            session_write_close();

            $target = ($data['role'] == 'admin') ? "admin_dashboard.php" : "dashboard.php";
            
            // Redirect menggunakan JS lebih aman di Vercel
            echo "<script>window.location.href='$target';</script>";
            exit();
        } else {
            echo "<script>alert('Password salah!'); window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('User tidak ditemukan!'); window.location='login.php';</script>";
    }
}
ob_end_flush();