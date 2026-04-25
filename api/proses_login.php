<?php
ob_start();
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(dirname(__FILE__) . '/koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $nik = mysqli_real_escape_string($conn, $_POST['nik']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE email='$email' AND nik='$nik' LIMIT 1";
    $query = mysqli_query($conn, $sql);

    if ($query && mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);

        if (password_verify($password, $data['password'])) {
            // Set Session
            $_SESSION['login'] = true;
            $_SESSION['role']  = $data['role'];
            $_SESSION['email'] = $data['email'];
            
            // PAKSA SIMPAN SESSION
            session_write_close(); 

            // Redirect menggunakan JS agar lebih stabil di Vercel
            $target = ($data['role'] == 'admin') ? "admin_dashboard.php" : "dashboard.php";
            echo "<script>
                    console.log('Login sukses, mengalihkan...');
                    window.location.href = '$target';
                  </script>";
            exit();
        } else {
            echo "<script>alert('Password salah!'); window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('User tidak ditemukan!'); window.location='login.php';</script>";
    }
} else {
    header("Location: login.php");
}
ob_end_flush();
?>