<?php
session_start();

// 1. Proteksi Session & Cookie (Vercel-Ready)
$isLogin = isset($_SESSION['login']) || (isset($_COOKIE['user_login']) && $_COOKIE['user_login'] === 'true');
$role    = $_SESSION['role'] ?? $_COOKIE['user_role'] ?? '';

if (!$isLogin || $role !== 'user') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pasien | RS Caruban</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-subtle { background-image: linear-gradient(135deg, #eff6ff 0%, #f8fafc 100%); }
    </style>
</head>

<body class="bg-subtle text-slate-900 min-h-screen flex flex-col antialiased">

<div class="max-w-4xl mx-auto p-4 md:p-8 w-full flex-1">
    <div class="mb-8">
        <a href="dashboard.php" class="inline-flex items-center gap-2 text-slate-500 hover:text-blue-600 transition-all font-bold text-sm">
            <div class="p-2 bg-white rounded-xl shadow-sm border border-slate-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </div>
            Kembali ke Dashboard
        </a>
    </div>

    <div class="bg-white border border-slate-100 rounded-[2.5rem] shadow-2xl shadow-blue-900/5 overflow-hidden">
        <div class="h-2 bg-gradient-to-r from-blue-600 to-emerald-500"></div>

        <div class="p-8 md:p-12">
            <header class="mb-10">
                <span class="bg-blue-50 text-blue-600 text-[10px] font-black px-4 py-2 rounded-full uppercase tracking-widest">Layanan Mandiri</span>
                <h1 class="text-3xl font-black text-slate-800 mt-4 tracking-tight">Pendaftaran Pasien</h1>
                <p class="text-slate-500 font-medium text-sm">Silakan lengkapi data untuk pendaftaran poliklinik.</p>
            </header>

            <form method="POST" action="proses_pendaftaran.php" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Pasien</label>
                        <input type="text" name="nama" required placeholder="Nama Lengkap" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 transition-all outline-none font-medium">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">NIK (16 Digit)</label>
                        <input type="text" name="nik" required placeholder="NIK Pasien" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 transition-all outline-none font-mono">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">No. WhatsApp</label>
                        <input type="text" name="no_hp" required placeholder="08xxx" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 transition-all outline-none font-medium">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4">
                    <div>
                        <label class="block text-[10px] font-black text-blue-600 uppercase tracking-widest mb-2 ml-1">Poli Tujuan</label>
                        <select name="poli" required class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white outline-none font-bold text-slate-700">
                            <option value="" disabled selected>Pilih Poliklinik...</option>
                            <option>Poli Umum</option>
                            <option>Poli Gigi</option>
                            <option>Poli Anak</option>
                            <option>Poli Jantung</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-blue-600 uppercase tracking-widest mb-2 ml-1">Dokter Spesialis</label>
                        <select name="dokter" required class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white outline-none font-bold text-slate-700">
                            <option value="" disabled selected>Pilih Dokter...</option>
                            <option>Dr. Dante</option>
                            <option>Dr. Vergil</option>
                            <option>Dr. Nero</option>
                        </select>
                    </div>
                </div>

                <div class="pt-8">
                    <button type="submit" class="w-full bg-slate-900 text-white p-5 rounded-2xl font-black text-sm uppercase tracking-[0.2em] hover:bg-blue-600 transition-all shadow-xl active:scale-95 flex items-center justify-center gap-3 cursor-pointer">
                        Konfirmasi Pendaftaran
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<footer class="py-8 text-center">
    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">SISTEM RS CARUBAN • © 2026</p>
</footer>

</body>
</html>