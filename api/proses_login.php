<?php
session_start();
include 'koneksi.php';

$email = $_POST['email'];
$nik = $_POST['nik'];
$password = $_POST['password'];

$query = mysqli_query($conn, "SELECT * FROM user WHERE email='$email' AND nik='$nik'");
$data = mysqli_fetch_assoc($query);

if ($data) {

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
    echo "<script>alert('User tidak ditemukan'); window.location='login.php';</script>";
}
?>