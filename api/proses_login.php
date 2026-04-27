<?php
session_start();
require_once(dirname(__FILE__) . '/koneksi.php');

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
            $_SESSION['login'] = true;
            $_SESSION['role']  = $data['role'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['nama_akun'] = $data['nama'];
            $_SESSION['nik_akun']  = $data['nik'];
            // -----------------------------------------------------------------

            $expiry = time() + (7200);
            setcookie('user_login', 'true', $expiry, "/");
            setcookie('user_role', $data['role'], $expiry, "/");
            setcookie('user_email', $data['email'], $expiry, "/");

            $target = ($data['role'] == 'admin') ? "admin_dashboard.php" : "dashboard.php";
            
            echo "<script>window.location.href='$target';</script>";
            exit();
        } else {
            echo "<script>alert('KATA SANDI SALAH!'); window.location.href='login.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('EMAIL ATAU NIK TIDAK TERDAFTAR!'); window.location.href='login.php';</script>";
        exit();
    }
}
?>