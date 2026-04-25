<?php
// 1. Inisialisasi Session paling atas
session_set_cookie_params(0, '/'); 
session_start();

// 2. Panggil koneksi (yang tadi sudah terbukti berhasil)
require_once 'koneksi.php';

// 3. Ambil data dari form
$email = mysqli_real_escape_string($koneksi, $_POST['email'] ?? '');
$nik   = mysqli_real_escape_string($koneksi, $_POST['nik'] ?? '');
$pass  = $_POST['password'] ?? '';

// 4. Cek apakah input kosong
if (empty($email) || empty($nik) || empty($pass)) {
    echo "<script>alert('Data tidak boleh kosong!'); window.location.href='/index.html';</script>";
    exit;
}

// 5. Cari user di database
$sql = "SELECT * FROM user WHERE email='$email' AND nik='$nik' LIMIT 1";
$query = mysqli_query($koneksi, $sql);
$data = mysqli_fetch_assoc($query);

if ($data) {
    // 6. Verifikasi Password (karena kamu bilang sudah di-hash)
    if (password_verify($pass, $data['password'])) {
        
        // Simpan data ke session
        $_SESSION['login'] = true;
        $_SESSION['email'] = $data['email'];
        $_SESSION['role']  = strtolower(trim($data['role']));

        // Kunci session sebelum pindah halaman
        session_write_close();

        // 7. Tentukan halaman tujuan
        $redirect_to = ($_SESSION['role'] === 'admin') ? 'admin_dashboard.php' : 'dashboard.php';
        
        // Gunakan JavaScript Redirect agar tidak blank di Vercel
        echo "<script>window.location.href='/api/$redirect_to';</script>";
        exit;

    } else {
        // Password salah
        echo "<script>alert('Password salah!'); window.location.href='/index.html?error=1';</script>";
        exit;
    }
} else {
    // User tidak ditemukan
    echo "<script>alert('Email atau NIK tidak terdaftar!'); window.location.href='/index.html?error=1';</script>";
    exit;
}
?>