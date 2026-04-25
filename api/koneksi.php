<?php
$host = 'gateway01.ap-southeast-1.prod.alicloud.tidbcloud.com';
$port = 4000;
$user = '3ZiKq6ZtEHR33K2.root';
$pass = 'Sns4kG97NEXoBaRN';
$db   = 'UTS-RSCaruban';

$conn = mysqli_init();
mysqli_options($conn, MYSQLI_OPT_CONNECT_TIMEOUT, 10); // Naikkan timeout jadi 10 detik

// Tambahkan minimal satu parameter SSL jika TiDB Cloud
if (defined('MYSQLI_CLIENT_SSL')) {
    mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);
}

$real_connect = @mysqli_real_connect($conn, $host, $user, $pass, $db, $port, NULL, MYSQLI_CLIENT_SSL);

if (!$real_connect) {
    // Jangan pakai die saja, beri info errornya
    error_log("Koneksi TiDB Gagal: " . mysqli_connect_error());
    die("Koneksi database bermasalah. Silakan cek koneksi internet atau konfigurasi DB.");
}
?>