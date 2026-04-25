<?php
ob_start(); // Mencegah error output sebelum redirect
session_start();

// Pastikan file koneksi terpanggil dengan benar
require_once(dirname(__FILE__) . '/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $nik = mysqli_real_escape_string($conn, $_POST['nik']);
    $password = $_POST['password'];

    // Query sederhana dulu untuk memastikan data narik
    $sql = "SELECT * FROM user WHERE email='$email' AND nik='$nik' LIMIT 1";
    $query = mysqli_query($conn, $sql);

    if ($query && mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);

        if (password_verify($password, $data['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['role']  = $data['role'];
            $_SESSION['email'] = $data['email'];

            // Gunakan path absolut untuk redirect di Vercel
            if ($data['role'] == 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
        } else {
            echo "<script>alert('Password salah!'); window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('User tidak ditemukan!'); window.location='login.php';</script>";
    }
} else {
    header("Location: login.php");
}
ob_end_flush();
?>