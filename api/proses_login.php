<?php
// 1. Tambahkan pengaman cookie path agar session terbaca di semua folder
session_set_cookie_params(0, '/'); 
session_start();

include 'koneksi.php';

$email = $_POST['email'] ?? '';
$nik   = $_POST['nik'] ?? '';
$pass  = $_POST['password'] ?? '';

if ($email == '' || $nik == '' || $pass == '') {
    echo "<script>alert('Data harus lengkap'); window.location='/index.html';</script>";
    exit;
}

// 2. Gunakan mysqli_real_escape_string untuk keamanan (mencegah SQL Injection)
$email = mysqli_real_escape_string($koneksi, $email);
$nik   = mysqli_real_escape_string($koneksi, $nik);

$query = mysqli_query($koneksi, "SELECT * FROM user WHERE email='$email' AND nik='$nik'");
$data  = mysqli_fetch_assoc($query);

if ($data) {
    if (password_verify($pass, $data['password'])) {

        // 3. Simpan data ke Session dengan bersih
        $_SESSION['login'] = true;
        $_SESSION['email'] = $data['email'];
        $_SESSION['role']  = strtolower(trim($data['role'])); // Solusi VARCHAR

        // 4. PENTING: Paksa session tersimpan sebelum redirect
        session_write_close();

        if ($_SESSION['role'] === 'admin') {
            header("Location: /api/admin_dashboard.php"); 
        } else {
            header("Location: /api/dashboard.php"); 
        }
        exit;

    } else {
        echo "<script>alert('Password salah'); window.location='/index.html';</script>";
    }
} else {
    echo "<script>alert('Akun tidak ditemukan'); window.location='/index.html';</script>";
}
?>