<?php
include 'koneksi.php';

$nama   = mysqli_real_escape_string($conn, $_POST['nama']);
$nik    = mysqli_real_escape_string($conn, $_POST['nik']);
$no_hp  = mysqli_real_escape_string($conn, $_POST['no_hp']);
$alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
$email  = mysqli_real_escape_string($conn, $_POST['email']);

$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$role = 'admin';

$query = "INSERT INTO user (nama, nik, no_hp, alamat, email, password, role) 
          VALUES ('$nama', '$nik', '$no_hp', '$alamat', '$email', '$password', '$role')";

if (mysqli_query($conn, $query)) {
    echo "<script>alert('Admin baru berhasil didaftarkan!'); window.location='admin_dashboard.php';</script>";
} else {
    echo "Gagal menyimpan data: " . mysqli_error($conn);
}
?>