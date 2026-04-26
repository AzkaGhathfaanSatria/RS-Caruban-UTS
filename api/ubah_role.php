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
    die("Akses ditolak! Anda tidak memiliki izin mengubah role.");
}
// ----------------------------------------------

$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

if (!empty($id)) {
    $query = mysqli_query($conn, "SELECT role FROM user WHERE id='$id'");
    $data  = mysqli_fetch_assoc($query);

    if ($data) {
        $new_role = ($data['role'] == 'admin') ? 'user' : 'admin';
        mysqli_query($conn, "UPDATE user SET role='$new_role' WHERE id='$id'");
    }
}

header("Location: admin_dashboard.php");
exit();
?>