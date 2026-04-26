<?php
session_start();
require_once 'koneksi.php'; // Pastikan file koneksi ada di folder yang sama

// 1. PROTEKSI SUPER KETAT (Hybrid Session & Cookie)
$isLogin = isset($_SESSION['login']) || (isset($_COOKIE['user_login']) && $_COOKIE['user_login'] === 'true');
$role    = $_SESSION['role'] ?? $_COOKIE['user_role'] ?? '';

// Jika tidak login ATAU role bukan admin, lempar ke login
if (!$isLogin || $role !== 'admin') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Staf | RS Caruban</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>

<body class="bg-[#fcfcfd] min-h-screen flex flex-col justify-center items-center p-6 antialiased">

<div class="bg-white p-8 md:p-12 rounded-[3rem] shadow-2xl shadow-slate-200 w-full max-w-2xl border border-slate-50">
    <header class="text-center mb-8">
        <a href="admin_dashboard.php" class="inline-block mb-4 text-[10px] font-black text-blue-600 uppercase tracking-widest bg-blue-50 px-4 py-2 rounded-full hover:bg-blue-100 transition-colors">
            ← Kembali ke Panel
        </a>
        <h1 class="text-3xl font-black text-slate-900 tracking-tight">Registrasi Staf</h1>
        <p class="text-slate-400 font-medium mt-1 text-sm">Buat akses Administrator baru di sistem.</p>
    </header>

    <form method="POST" action="proses_tambah_admin.php" class="grid grid-cols-1 md:grid-cols-2 gap-5">
        
        <div class="md:col-span-2">
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Nama Lengkap</label>
            <input type="text" name="nama" required placeholder="Nama Lengkap Staf" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-50 outline-none font-bold text-slate-700 transition-all">
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">NIK</label>
            <input type="text" name="nik" required placeholder="16 Digit" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-50 outline-none font-bold text-slate-700 transition-all font-mono">
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">WhatsApp</label>
            <input type="text" name="no_hp" required placeholder="081xxx" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-50 outline-none font-bold text-slate-700 transition-all">
        </div>

        <div class="md:col-span-2">
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Alamat</label>
            <textarea name="alamat" required placeholder="Alamat lengkap..." rows="2" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-50 outline-none font-bold text-slate-700 transition-all"></textarea>
        </div>

        <div class="md:col-span-2">
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1 text-blue-600">Email Login</label>
            <input type="email" name="email" required placeholder="email@rscaruban.com" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-50 outline-none font-bold text-slate-700 transition-all">
        </div>

        <div class="md:col-span-2">
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1 text-blue-600">Password</label>
            <input type="password" name="password" required placeholder="Minimal 8 karakter" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-50 outline-none font-bold text-slate-700 transition-all">
        </div>

        <button type="submit" class="md:col-span-2 w-full bg-slate-900 text-white p-5 rounded-[2rem] font-black text-[11px] uppercase tracking-[0.2em] hover:bg-blue-600 shadow-xl shadow-slate-100 transition-all active:scale-95 cursor-pointer">
            Berikan Akses Administrator
        </button>
    </form>
</div>

<footer class="mt-8">
    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">SISTEM INTERNAL RS CARUBAN</p>
</footer>

</body>
</html>