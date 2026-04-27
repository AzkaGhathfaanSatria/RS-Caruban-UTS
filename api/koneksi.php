<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'gateway01.ap-southeast-1.prod.alicloud.tidbcloud.com';
$port = 4000;
$user = '3ZiKq6ZtEHR33K2.root';
$pass = 'Sns4kG97NEXoBaRN';
$db   = 'UTS-RSCaruban';

$conn = mysqli_init();
if (!$conn) {
    die("mysqli_init failed");
}

mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 10);

if (!mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL)) {
    die("Setting SSL failed");
}

$real_connect = mysqli_real_connect($conn, $host, $user, $pass, $db, $port, NULL, MYSQLI_CLIENT_SSL);

if (!$real_connect) {
    die("Koneksi TiDB Gagal: " . mysqli_connect_error());
}
?>