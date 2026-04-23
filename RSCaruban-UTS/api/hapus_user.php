<?php
include 'koneksi.php';

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM user WHERE id='$id'");

header("Location: admin_dashboard.php");
?>