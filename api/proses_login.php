<?php
session_start();
require_once(dirname(__FILE__) . '/koneksi.php');

// Pastikan koneksi menggunakan variabel yang benar
$db = isset($conn) ? $conn : $koneksi;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $nik = mysqli_real_escape_string($db, $_POST['nik']);
    $password = $_POST['password'];

    // Cari user berdasarkan email DAN nik
    $sql = "SELECT * FROM user WHERE email='$email' AND nik='$nik' LIMIT 1";
    $query = mysqli_query($db, $sql);

    if ($query && mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);

        // Verifikasi Password
        if (password_verify($password, $data['password'])) {
            // 1. Simpan di Session
            $_SESSION['login'] = true;
            $_SESSION['role']  = $data['role'];
            $_SESSION['email'] = $data['email'];

            // 2. Simpan di Cookie (Aktif 2 jam)
            $expiry = time() + (7200);
            setcookie('user_login', 'true', $expiry, "/");
            setcookie('user_role', $data['role'], $expiry, "/");
            setcookie('user_email', $data['email'], $expiry, "/");

            // Tutup session agar tersimpan sebelum redirect
            session_write_close();

            // Redirect sesuai role
            $target = ($data['role'] == 'admin') ? "admin_dashboard.php" : "dashboard.php";
            header("Location: $target");
            exit();
        } else {
            // Password Salah
            $_SESSION['error'] = "Kata sandi yang Anda masukkan salah!";
            session_write_close();
            header("Location: login.php");
            exit();
        }
    } else {
        // Akun Tidak Ditemukan
        $_SESSION['error'] = "Email atau NIK tidak terdaftar!";
        session_write_close();
        header("Location: login.php");
        exit();
    }
}
?>