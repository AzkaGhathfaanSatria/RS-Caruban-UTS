<?php
session_start();
include 'koneksi.php';

// Ambil data dengan aman
$email = $_POST['email'] ?? '';
$nik = $_POST['nik'] ?? '';
$password = $_POST['password'] ?? '';

// Validasi input
if ($email == '' || $nik == '' || $password == '') {
    echo "<script>alert('Data harus lengkap'); window.location='../login.php';</script>";
    exit;
}

// Query
$query = mysqli_query($koneksi, "SELECT * FROM user WHERE email='$email' AND nik='$nik'");

if (!$query) {
    die("Query error: " . mysqli_error($koneksi));
}

$data = mysqli_fetch_assoc($query);

if ($data) {

    if (password_verify($password, $data['password'])) {

        $_SESSION['login'] = true;
        $_SESSION['role'] = strtolower(trim($data['role'])); // 🔥 FIX UTAMA
        $_SESSION['email'] = $data['email'];

        // Redirect sesuai role
        if ($_SESSION['role'] == 'admin') {
            header("Location: ../admin_dashboard.php"); // 🔥 FIX PATH
        } else {
            header("Location: ../dashboard.php"); // 🔥 FIX PATH
        }
        exit;

    } else {
        echo "<script>alert('Password salah'); window.location='../login.php';</script>";
    }

} else {
    echo "<script>alert('User tidak ditemukan'); window.location='../login.php';</script>";
}
?>