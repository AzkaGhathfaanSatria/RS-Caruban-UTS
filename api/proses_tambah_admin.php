<?php
session_start();
include 'koneksi.php';
$conn = $koneksi ?? $conn;

// --- PROTEKSI HYBRID (Cek Session + Cookie) ---
if (!isset($_SESSION['login']) && isset($_COOKIE['user_login'])) {
    $_SESSION['login'] = true;
    $_SESSION['role']  = $_COOKIE['user_role'];
    $_SESSION['email'] = $_COOKIE['user_email'];
}

$role_check = $_SESSION['role'] ?? '';
if (!isset($_SESSION['login']) || $role_check !== 'admin') {
    die("Akses ditolak! Sistem tidak mengenali status Admin Anda.");
}
// ----------------------------------------------

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
    $nik    = mysqli_real_escape_string($conn, $_POST['nik']);
    $no_hp  = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $email  = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role   = 'admin';

    // Cek Duplikat
    $cek = mysqli_query($conn, "SELECT id FROM user WHERE email='$email' OR nik='$nik'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Error: Email atau NIK sudah digunakan!'); window.history.back();</script>";
        exit();
    }

    $query = "INSERT INTO user (nama, nik, no_hp, alamat, email, password, role) 
              VALUES ('$nama', '$nik', '$no_hp', '$alamat', '$email', '$password', '$role')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Admin baru berhasil didaftarkan!'); window.location='admin_dashboard.php';</script>";
    } else {
        echo "Gagal: " . mysqli_error($conn);
    }
}
?>