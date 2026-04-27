<?php
require_once(dirname(__FILE__) . '/koneksi.php');

// Pastikan variabel koneksi aman
if (!isset($koneksi) && isset($conn)) {
    $koneksi = $conn;
}

if (!$koneksi) {
    die("Koneksi gagal: Variabel database tidak ditemukan.");
}

// Ambil data dan bersihkan spasi (trim)
$email    = mysqli_real_escape_string($koneksi, trim($_POST['email']));
$nama     = mysqli_real_escape_string($koneksi, trim($_POST['nama']));
$nik      = mysqli_real_escape_string($koneksi, trim($_POST['nik']));
$password = $_POST['password']; 
$no_hp    = mysqli_real_escape_string($koneksi, trim($_POST['no_hp']));
$alamat   = mysqli_real_escape_string($koneksi, trim($_POST['alamat']));
$role     = 'user';

// --- VALIDASI FORMAT ---
if (strlen($nik) != 16) {
    echo "<script>alert('NIK harus 16 digit!'); window.history.back();</script>";
    exit;
}

if (strlen($password) < 8 || strlen($password) > 16) {
    echo "<script>alert('Password harus antara 8-16 karakter!'); window.history.back();</script>";
    exit;
}

// --- TRIPLE CHECK: CEK EMAIL, NIK, & NO HP SEKALIGUS ---
$sql_cek = "SELECT email, nik, no_hp FROM user WHERE email = '$email' OR nik = '$nik' OR no_hp = '$no_hp' LIMIT 1";
$query_cek = mysqli_query($koneksi, $sql_cek);

if (mysqli_num_rows($query_cek) > 0) {
    $data_ada = mysqli_fetch_assoc($query_cek);
    
    if ($data_ada['email'] == $email) {
        $pesan = "Email sudah terdaftar!";
    } else if ($data_ada['nik'] == $nik) {
        $pesan = "NIK sudah terdaftar! Gunakan NIK Anda sendiri.";
    } else if ($data_ada['no_hp'] == $no_hp) {
        $pesan = "Nomor WhatsApp sudah digunakan akun lain!";
    }
    
    echo "<script>alert('$pesan'); window.history.back();</script>";
    exit;
}

// --- JIKA LOLOS VALIDASI, BARU SIMPAN ---
$password_hash = password_hash($password, PASSWORD_DEFAULT);

$query = "INSERT INTO user (email, nik, password, nama, no_hp, alamat, role)
          VALUES ('$email', '$nik', '$password_hash', '$nama', '$no_hp', '$alamat', '$role')";

if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Registrasi berhasil! Silakan Login.'); window.location='login.php';</script>";
} else {
    echo "Gagal: " . mysqli_error($koneksi);
}
?>