<?php
// 1. Panggil koneksi dengan cara yang aman untuk Vercel
require_once(dirname(__FILE__) . '/koneksi.php');

/** * 2. LOGIKA PENYELAMAT VARIABEL 
 * Jika di koneksi.php kamu pakai $conn, baris ini akan otomatis 
 * mengubahnya jadi $koneksi supaya tidak error lagi.
 */
if (!isset($koneksi) && isset($conn)) {
    $koneksi = $conn;
}

// Cek apakah koneksi benar-benar ada
if (!$koneksi) {
    die("Koneksi gagal: Variabel database tidak ditemukan. Cek isi koneksi.php kamu.");
}

// 3. Ambil data dan bersihkan (Security)
$email    = mysqli_real_escape_string($koneksi, $_POST['email']);
$nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
$nik      = mysqli_real_escape_string($koneksi, $_POST['nik']);
$password = $_POST['password']; 
$no_hp    = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
$alamat   = mysqli_real_escape_string($koneksi, $_POST['alamat']);
$role     = 'user';

// 4. Validasi Dasar
if (strlen($nik) != 16) {
    echo "<script>alert('NIK harus 16 digit!'); window.history.back();</script>";
    exit;
}

// 5. Cek Email Ganda sebelum Insert
$cek = mysqli_query($koneksi, "SELECT email FROM user WHERE email = '$email'");
if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Email sudah terdaftar!'); window.history.back();</script>";
    exit;
}

// 6. Hash Password (Keamanan)
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// 7. Insert ke TiDB (Tanpa kolom 'id' karena sudah AUTO_INCREMENT)
$query = "INSERT INTO user (email, nik, password, nama, no_hp, alamat, role)
          VALUES ('$email', '$nik', '$password_hash', '$nama', '$no_hp', '$alamat', '$role')";

if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Registrasi berhasil!'); window.location='login.php';</script>";
} else {
    echo "Gagal: " . mysqli_error($koneksi);
}
?>