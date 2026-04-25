<?php
$host = 'gateway01.ap-southeast-1.prod.alicloud.tidbcloud.com';
$port = 4000;
$user = '3ZiKq6ZtEHR33K2.root';
$pass = 'Sns4kG97NEXoBaRN';
$db   = 'UTS-RSCaruban';

$koneksi = mysqli_init();
mysqli_options($koneksi, MYSQLI_OPT_CONNECT_TIMEOUT, 5);
mysqli_ssl_set($koneksi, NULL, NULL, NULL, NULL, NULL);

$real_connect = mysqli_real_connect(
    $koneksi, 
    $host, 
    $user, 
    $pass, 
    $db, 
    $port,
    NULL, 
    MYSQLI_CLIENT_SSL
);

if (!$real_connect) {
    die("Koneksi Gagal");
}
// JANGAN ADA ECHO ATAU TEXT DI SINI
?>