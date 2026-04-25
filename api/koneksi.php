<?php
// Data dari TiDB Cloud
$host = 'gateway01.ap-southeast-1.prod.alicloud.tidbcloud.com';
$port = 4000;
$user = '3ZiKq6ZtEHR33K2.root';
$pass = 'Sns4kG97NEXoBaRN';
$db   = 'UTS-RSCaruban';

// 1. Matikan peringatan mysqli yang bisa bikin blank di beberapa server
mysqli_report(MYSQLI_REPORT_OFF);

$koneksi = mysqli_init();

// 2. Tambahkan Timeout agar tidak "blank" kelamaan kalau koneksi lambat
mysqli_options($koneksi, MYSQLI_OPT_CONNECT_TIMEOUT, 5);

// 3. Pengaturan SSL (Wajib untuk TiDB Serverless)
// Di Vercel/Produksi, parameter NULL sudah cukup untuk mengaktifkan enkripsi default
mysqli_ssl_set($koneksi, NULL, NULL, NULL, NULL, NULL);

// 4. Proses Koneksi
$real_connect = @mysqli_real_connect(
    $koneksi, 
    $host, 
    $user, 
    $pass, 
    $db, 
    $port,
    NULL, 
    MYSQLI_CLIENT_SSL
);

// 5. Cek Koneksi dengan Error Handling yang Jelas
if (!$real_connect) {
    // Jika gagal, tampilkan pesan agar kita tahu masalahnya, bukan cuma layar putih
    die("Koneksi TiDB Gagal: " . mysqli_connect_error());
}

// 6. Set Charset agar data VARCHAR terbaca dengan benar (Penting!)
mysqli_set_charset($koneksi, "utf8mb4");
?>