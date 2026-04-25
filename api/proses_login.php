<?php
session_start();
// File koneksi harus ada di dalam folder api juga
include 'koneksi.php';

// Ambil data dengan aman
$email = $_POST['email'] ?? '';
$nik = $_POST['nik'] ?? '';
$password = $_POST['password'] ?? '';

// Validasi input
if ($email == '' || $nik == '' || $password == '') {
    // Arahkan ke index.html di root
    echo "<script>alert('Data harus lengkap'); window.location='/index.html';</script>";
    exit;
}

// Query ke TiDB (Pastikan nama tabel 'user' sudah benar)
$query = mysqli_query($koneksi, "SELECT * FROM user WHERE email='$email' AND nik='$nik'");

if (!$query) {
    die("Query error: " . mysqli_error($koneksi));
}

$data = mysqli_fetch_assoc($query);

if ($data) {
    // Verifikasi Password (Pastikan saat register kamu pakai password_hash)
    if (password_verify($password, $data['password'])) {

        $_SESSION['login'] = true;
        $_SESSION['role'] = strtolower(trim($data['role'])); 
        $_SESSION['email'] = $data['email'];

        // REDIRECT HARUS MENYEBUTKAN /api/ 
        if ($_SESSION['role'] == 'admin') {
            header("Location: /api/admin_dashboard.php"); 
        } else {
            header("Location: /api/dashboard.php"); 
        }
        exit;

    } else {
        // Balik ke login di root
        echo "<script>alert('Password salah'); window.location='/index.html';</script>";
    }

} else {
    // Balik ke login di root
    echo "<script>alert('User tidak ditemukan'); window.location='/index.html';</script>";
}
?>