<?php
ob_start();
session_start();
require_once(dirname(__FILE__) . '/koneksi.php');

// Pastikan koneksi menggunakan variabel yang benar ($conn atau $koneksi)
$db = isset($conn) ? $conn : $koneksi;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $nik = mysqli_real_escape_string($db, $_POST['nik']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE email='$email' AND nik='$nik' LIMIT 1";
    $query = mysqli_query($db, $sql);

    if ($query && mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);

        if (password_verify($password, $data['password'])) {
            // 1. Simpan di Session
            $_SESSION['login'] = true;
            $_SESSION['role']  = $data['role']; // Pastikan di DB isinya 'admin' atau 'user'
            $_SESSION['email'] = $data['email'];

            // 2. Simpan di Cookie (PENTING: Gunakan path "/" agar terbaca di semua folder)
            $expiry = time() + (7200); // Kita buat 2 jam biar nggak gampang logout
            setcookie('user_login', 'true', $expiry, "/");
            setcookie('user_role', $data['role'], $expiry, "/");
            setcookie('user_email', $data['email'], $expiry, "/");

            // Tutup session agar tersimpan permanen sebelum redirect
            session_write_close();

            // Tentukan target redirect
            $target = ($data['role'] == 'admin') ? "admin_dashboard.php" : "dashboard.php";
            
            echo "<script>window.location.href='$target';</script>";
            exit();
        } else {
            $_SESSION['error'] = "Password salah!";
            echo "<script>window.location.href='login.php';</script>";
        }
    } else {
        $_SESSION['error'] = "Email atau NIK tidak terdaftar!";
        echo "<script>window.location.href='login.php';</script>";
    }
}
ob_end_flush();
?>