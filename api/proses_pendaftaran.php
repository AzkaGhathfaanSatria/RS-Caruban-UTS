<?php
session_start();
require_once(dirname(__FILE__) . '/koneksi.php');

// 1. Ambil identitas dari Session ATAU Cookie
$isLogin = isset($_SESSION['login']) || (isset($_COOKIE['user_login']) && $_COOKIE['user_login'] === 'true');
$email   = $_SESSION['email'] ?? $_COOKIE['user_email'] ?? '';

// 2. Proteksi Ganda: Jika tidak ada bukti login, tendang balik
if (!$isLogin || empty($email)) {
    echo "<script>
            alert('Akses ditolak! Sesi Anda berakhir, silakan login kembali.'); 
            window.location='login.php';
          </script>";
    exit();
}

// 3. Proses Data (Hanya jika ada data POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitasi input agar aman dari SQL Injection
    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
    $nik    = mysqli_real_escape_string($conn, $_POST['nik']);
    $no_hp  = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $poli   = mysqli_real_escape_string($conn, $_POST['poli']);
    $dokter = mysqli_real_escape_string($conn, $_POST['dokter']);

    // Query simpan data (Pastikan nama tabel dan kolom sesuai database kamu)
    $query = "INSERT INTO pasien (email, nama, nik, no_hp, poli, dokter, tanggal)
              VALUES ('$email', '$nama', '$nik', '$no_hp', '$poli', '$dokter', NOW())";

    if (mysqli_query($conn, $query)) {
        echo "<script>
                alert('Pendaftaran berhasil!'); 
                window.location='riwayat.php';
              </script>";
    } else {
        // Jika gagal karena database, tampilkan errornya
        echo "Gagal menyimpan data: " . mysqli_error($conn);
    }
} else {
    // Jika akses file ini tanpa isi form
    header("Location: pendaftaran.php");
    exit();
}
?>