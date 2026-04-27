<?php
ob_start();
session_start();
require_once 'koneksi.php';
$conn = $koneksi ?? $conn;

// 1. SINKRONISASI SESSION & COOKIE
if (!isset($_SESSION['login']) && isset($_COOKIE['user_login'])) {
    $_SESSION['login'] = true;
    $_SESSION['role']  = $_COOKIE['user_role'];
    $_SESSION['email'] = $_COOKIE['user_email'];
}

// 2. CEK KEAMANAN: Harus Login & Harus Admin
$role_check = $_SESSION['role'] ?? '';
if (!isset($_SESSION['login']) || $role_check !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Registrasi Staf | RS Caruban</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fcfcfd;
        }
        input::placeholder, textarea::placeholder {
            font-weight: 400;
            font-size: 0.85rem;
            opacity: 0.5;
        }
    </style>
</head>

<body class="min-h-screen flex flex-col items-center p-4 md:p-6 antialiased">

<div class="w-full max-w-2xl mt-4 md:mt-10">
    <div class="mb-6">
        <a href="admin_dashboard.php" class="inline-flex items-center gap-2 text-[10px] font-black text-slate-400 hover:text-blue-600 uppercase tracking-widest transition-all">
            <span class="bg-white p-2 rounded-lg border border-slate-100 shadow-sm">←</span>
            Kembali ke Panel
        </a>
    </div>

    <div class="bg-white p-6 md:p-12 rounded-[2rem] md:rounded-[3rem] shadow-2xl shadow-slate-200 border border-slate-50">
        <header class="text-center mb-8 md:mb-10">
            <div class="inline-block p-3 bg-blue-50 text-blue-600 rounded-2xl mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <h1 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">Registrasi Staf</h1>
            <p class="text-slate-400 font-medium mt-1 text-xs md:text-sm">Buat akses Administrator baru di sistem.</p>
        </header>

        <form method="POST" action="proses_tambah_admin.php" class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
            
            <div class="md:col-span-2">
                <label class="block text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Nama Lengkap</label>
                <input type="text" name="nama" required placeholder="Nama Lengkap Staf" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-xl md:rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-50 outline-none font-bold text-slate-700 transition-all text-sm">
            </div>

            <div>
                <label class="block text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">NIK</label>
                <input type="text" name="nik" required inputmode="numeric" placeholder="16 Digit" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-xl md:rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-50 outline-none font-bold text-slate-700 transition-all font-mono text-sm">
            </div>

            <div>
                <label class="block text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">WhatsApp</label>
                <input type="tel" name="no_hp" required placeholder="081xxx" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-xl md:rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-50 outline-none font-bold text-slate-700 transition-all text-sm">
            </div>

            <div class="md:col-span-2">
                <label class="block text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Alamat</label>
                <textarea name="alamat" required placeholder="Alamat lengkap..." rows="2" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-xl md:rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-50 outline-none font-bold text-slate-700 transition-all text-sm"></textarea>
            </div>

            <div class="md:col-span-2">
                <div class="h-px bg-slate-100 my-2"></div>
            </div>

            <div class="md:col-span-2">
                <label class="block text-[9px] md:text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-2 ml-1">Email Login</label>
                <input type="email" name="email" required placeholder="email@rscaruban.com" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-xl md:rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-50 outline-none font-bold text-slate-700 transition-all text-sm">
            </div>

            <div class="md:col-span-2">
                <label class="block text-[9px] md:text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-2 ml-1">Password</label>
                <input type="password" name="password" required placeholder="Minimal 8 karakter" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-xl md:rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-50 outline-none font-bold text-slate-700 transition-all text-sm">
            </div>

            <div class="md:col-span-2 pt-4">
                <button type="submit" class="w-full bg-slate-900 text-white p-4 md:p-5 rounded-2xl md:rounded-[2rem] font-black text-[10px] md:text-[11px] uppercase tracking-[0.2em] hover:bg-blue-600 shadow-xl shadow-blue-100 transition-all active:scale-95 cursor-pointer">
                    Berikan Akses Admin
                </button>
            </div>
        </form>
    </div>
</div>

<footer class="mt-auto py-10">
    <p class="text-slate-400 text-[9px] md:text-[10px] font-black uppercase tracking-[0.2em] text-center">SISTEM INTERNAL RS CARUBAN • 2026</p>
</footer>

</body>
</html>

<?php ob_end_flush(); ?>