<?php
session_start();
include 'koneksi.php';
$conn = $koneksi ?? $conn;

// 1. KEAMANAN: Cek apakah yang akses beneran Admin
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    die("Akses ditolak!");
}

// 2. AMBIL ID & VALIDASI
$id = mysqli_real_escape_string($conn, $_GET['id']);

if (!empty($id)) {
    // 3. AMBIL ROLE SAAT INI (Cukup ambil kolom role saja agar ringan)
    $query = mysqli_query($conn, "SELECT role FROM user WHERE id='$id'");
    $data  = mysqli_fetch_assoc($query);

    if ($data) {
        // 4. LOGIKA TOGGLE (Tukar Role)
        $new_role = ($data['role'] == 'admin') ? 'user' : 'admin';

        // 5. UPDATE KE DATABASE
        mysqli_query($conn, "UPDATE user SET role='$new_role' WHERE id='$id'");
    }
}

// 6. KEMBALI KE DASHBOARD
header("Location: admin_dashboard.php");
exit();