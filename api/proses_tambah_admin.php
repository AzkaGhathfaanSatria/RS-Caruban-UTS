<?php
session_start();
require_once 'koneksi.php';
$conn = $koneksi ?? $conn;

if (!isset($_SESSION['login']) && isset($_COOKIE['user_login'])) {
    $_SESSION['login'] = true;
    $_SESSION['role']  = $_COOKIE['user_role'];
    $_SESSION['email'] = $_COOKIE['user_email'];
}

$role_check = $_SESSION['role'] ?? '';
if (!isset($_SESSION['login']) || $role_check !== 'admin') {
    die("Akses ditolak! Sistem tidak mengenali status Admin Anda.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama     = mysqli_real_escape_string($conn, trim($_POST['nama']));
    $nik      = mysqli_real_escape_string($conn, trim($_POST['nik']));
    $no_hp    = mysqli_real_escape_string($conn, trim($_POST['no_hp']));
    $alamat   = mysqli_real_escape_string($conn, trim($_POST['alamat']));
    $email    = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password_raw = $_POST['password'];
    $role     = 'admin';

    if (!ctype_digit($nik) || !ctype_digit($no_hp)) {
        echo "<script>alert('NIK dan Nomor WhatsApp harus angka saja!'); window.history.back();</script>";
        exit;
    }

    if (strlen($nik) != 16) {
        echo "<script>alert('NIK harus tepat 16 digit!'); window.history.back();</script>";
        exit;
    }
    if (strlen($no_hp) < 12 || strlen($no_hp) > 13) {
        echo "<script>alert('Nomor HP tidak valid (Wajib 12-13 digit)!'); window.history.back();</script>";
        exit;
    }

    if (strlen($password_raw) < 8 || strlen($password_raw) > 16) {
        echo "<script>alert('Password harus antara 8-16 karakter!'); window.history.back();</script>";
        exit;
    }

    $sql_cek = "SELECT email, nik, no_hp FROM user WHERE email = '$email' OR nik = '$nik' OR no_hp = '$no_hp' LIMIT 1";
    $query_cek = mysqli_query($conn, $sql_cek);

    if (mysqli_num_rows($query_cek) > 0) {
        $data_ada = mysqli_fetch_assoc($query_cek);
        
        if ($data_ada['email'] == $email) {
            $pesan = "Email sudah digunakan!";
        } else if ($data_ada['nik'] == $nik) {
            $pesan = "NIK sudah digunakan!";
        } else if ($data_ada['no_hp'] == $no_hp) {
            $pesan = "Nomor WhatsApp sudah digunakan!";
        }
        
        echo "<script>alert('Pendaftaran Gagal: $pesan'); window.history.back();</script>";
        exit;
    }

    $password_hash = password_hash($password_raw, PASSWORD_DEFAULT);
    $query = "INSERT INTO user (nama, nik, no_hp, alamat, email, password, role) 
              VALUES ('$nama', '$nik', '$no_hp', '$alamat', '$email', '$password_hash', '$role')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Admin baru berhasil ditambahkan!'); window.location='admin_dashboard.php';</script>";
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($conn);
    }
}
?>