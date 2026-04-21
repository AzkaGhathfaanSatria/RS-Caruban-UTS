<?php
include 'koneksi.php';

$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id='$id'"));

if ($data['role'] == 'admin') {
    $new_role = 'user';
} else {
    $new_role = 'admin';
}

mysqli_query($conn, "UPDATE user SET role='$new_role' WHERE id='$id'");

header("Location: admin_dashboard.php");
?>