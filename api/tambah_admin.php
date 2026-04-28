<?php
ob_start();
session_start();
require_once 'koneksi.php';
$conn = $koneksi ?? $conn;

if (!isset($_SESSION['login']) && isset($_COOKIE['user_login'])) {
    $_SESSION['login'] = true;
    $_SESSION['role']  = $_COOKIE['user_role'];
    $_SESSION['email'] = $_COOKIE['user_email'];
}

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
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fcfcfd; }
        input::placeholder, textarea::placeholder { font-weight: 400; font-size: 0.85rem; opacity: 0.5; }
    </style>
</head>

<body class="min-h-screen flex flex-col items-center p-4 md:p-6 antialiased text-slate-900">

<div class="w-full max-w-2xl mt-4 md:mt-10">
    <div class="mb-6">
        <a href="admin_dashboard.php" class="inline-flex items-center gap-2 text-[10px] font-black text-slate-400 hover:text-blue-600 uppercase tracking-widest transition-all">
            <span class="bg-white p-2 rounded-lg border border-slate-100 shadow-sm">←</span>
            Kembali ke Panel
        </a>
    </div>

    <div class="bg-white p-6 md:p-12 rounded-[2rem] md:rounded-[3rem] shadow-2xl shadow-slate-200 border border-slate-50">
        <header class="text-center mb-8 md:mb-10">
            <div class="inline-block p-3 bg-blue-50 text-blue-600 rounded-2xl mb-4 text-xs font-black uppercase tracking-widest">Akses Staf</div>
            <h1 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight italic">Registrasi Admin</h1>
            <p class="text-slate-400 font-medium mt-1 text-xs md:text-sm">Buat akun administrator baru untuk sistem.</p>
        </header>

        <form method="POST" action="proses_tambah_admin.php" class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-5">
            
            <div class="md:col-span-2">
                <label class="block text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1 text-blue-600">Nama Lengkap</label>
                <input type="text" name="nama" required placeholder="Nama Lengkap Staf" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-xl md:rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-50 outline-none font-bold text-slate-700 transition-all text-sm">
            </div>

            <div>
                <label class="block text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">NIK (16 Digit)</label>
                <input type="text" name="nik" required maxlength="16" minlength="16" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="Input angka saja" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-xl md:rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-50 outline-none font-bold text-slate-700 transition-all font-mono text-sm">
            </div>

            <div>
                <label class="block text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">WhatsApp</label>
                <input type="tel" name="no_hp" required maxlength="13" minlength="12" oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="081xxx (12-13 digit)" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-xl md:rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-50 outline-none font-bold text-slate-700 transition-all text-sm">
            </div>

            <div class="md:col-span-2">
                <label class="block text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Alamat</label>
                <textarea name="alamat" required placeholder="Alamat lengkap..." rows="2" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-xl md:rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-50 outline-none font-bold text-slate-700 transition-all text-sm"></textarea>
            </div>

            <div class="md:col-span-2"><div class="h-px bg-slate-100 my-2"></div></div>

            <div class="md:col-span-2">
                <label class="block text-[9px] md:text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-2 ml-1">Email Login</label>
                <input type="email" name="email" required placeholder="email@rscaruban.com" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-xl md:rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-50 outline-none font-bold text-slate-700 transition-all text-sm">
            </div>

            <div class="md:col-span-2 relative">
                <label class="block text-[9px] md:text-[10px] font-black text-blue-600 uppercase tracking-[0.2em] mb-2 ml-1">Password</label>
                <input type="password" id="password" name="password" required minlength="8" maxlength="16" placeholder="8-16 Karakter" class="w-full bg-slate-50 border border-slate-100 p-4 pr-12 rounded-xl md:rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-50 outline-none font-bold text-slate-700 transition-all text-sm">
                <button type="button" onclick="togglePW()" class="absolute right-4 top-[38px] text-slate-300 hover:text-blue-600 transition-all">
                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>

            <div class="md:col-span-2 pt-4">
                <button type="submit" class="w-full bg-slate-900 text-white p-4 md:p-5 rounded-2xl md:rounded-[2rem] font-black text-[10px] md:text-[11px] uppercase tracking-[0.3em] hover:bg-blue-600 shadow-2xl shadow-blue-900/10 transition-all active:scale-95 cursor-pointer">
                    Berikan Akses Admin
                </button>
            </div>
        </form>
    </div>
</div>

<footer class="mt-auto py-10">
    <p class="text-slate-400 text-[9px] md:text-[10px] font-black uppercase tracking-[0.2em] text-center">SISTEM INTERNAL RS CARUBAN • 2026</p>
</footer>

<script>
    function togglePW() {
        const pwInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');
        if (pwInput.type === "password") {
            pwInput.type = "text";
            eyeIcon.classList.add('text-blue-600');
        } else {
            pwInput.type = "password";
            eyeIcon.classList.remove('text-blue-600');
        }
    }
</script>

</body>
</html>
<?php ob_end_flush(); ?>