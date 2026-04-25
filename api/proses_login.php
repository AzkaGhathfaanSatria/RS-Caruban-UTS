<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Cek apakah file koneksi ada
if (!file_exists(dirname(__FILE__) . '/koneksi.php')) {
    die("File koneksi.php tidak ditemukan di: " . dirname(__FILE__));
}

require_once(dirname(__FILE__) . '/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $nik = $_POST['nik'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        die("Email atau Password kosong di POST.");
    }

    $email = mysqli_real_escape_string($conn, $email);
    $nik = mysqli_real_escape_string($conn, $nik);

    $sql = "SELECT * FROM user WHERE email='$email' AND nik='$nik' LIMIT 1";
    $query = mysqli_query($conn, $sql);

    if (!$query) {
        die("Query Error: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        
        // DEBUG: Cek apakah password match
        if (password_verify($password, $data['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['role']  = $data['role'];
            $_SESSION['email'] = $data['email'];

            // Cek file tujuan sebelum redirect
            $target = ($data['role'] == 'admin') ? "admin_dashboard.php" : "dashboard.php";
            
            echo "Login Berhasil. Mengalihkan ke $target...";
            echo "<script>window.location.href='$target';</script>";
            exit();
        } else {
            // DEBUG: Jika gagal, cek apakah password di DB itu hash atau teks biasa
            echo "<script>alert('Password tidak cocok dengan Hash di database.'); window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('Data tidak ditemukan di database.'); window.location='login.php';</script>";
    }
} else {
    echo "Metode bukan POST.";
}
?>