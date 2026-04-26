<?php
session_start();
include 'koneksi.php';
$conn = $koneksi ?? $conn;

// 1. KEAMANAN: Pastikan hanya admin yang bisa menjalankan proses ini
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    die("Akses ditolak!");
}

// 2. AMBIL DATA & ESCAPE (Mencegah SQL Injection)
$nama   = mysqli_real_escape_string($conn, $_POST['nama']);
$nik    = mysqli_real_escape_string($conn, $_POST['nik']);
$no_hp  = mysqli_real_escape_string($conn, $_POST['no_hp']);
$alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
$email  = mysqli_real_escape_string($conn, $_POST['email']);

// 3. HASH PASSWORD (Wajib untuk keamanan)
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role     = 'admin';

// 4. CEK DUPLIKAT: Agar tidak ada email/NIK yang sama (Opsional tapi sangat disarankan)
$cek = mysqli_query($conn, "SELECT id FROM user WHERE email='$email' OR nik='$nik'");
if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Error: Email atau NIK sudah digunakan!'); window.history.back();</script>";
    exit();
}

// 5. EKSEKUSI QUERY
$query = "INSERT INTO user (nama, nik, no_hp, alamat, email, password, role) 
          VALUES ('$nama', '$nik', '$no_hp', '$alamat', '$email', '$password', '$role')";

if (mysqli_query($conn, $query)) {
    echo "<script>alert('Admin baru berhasil didaftarkan!'); window.location='admin_dashboard.php';</script>";
} else {
    echo "Gagal: " . mysqli_error($conn);
}
?>