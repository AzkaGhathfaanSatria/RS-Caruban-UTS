<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pasien | RS Caruban</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-subtle {
            background-color: #f8fafc;
            background-image: linear-gradient(135deg, #eff6ff 0%, #f8fafc 100%);
        }
    </style>
</head>

<body class="bg-subtle text-slate-900 min-h-screen flex flex-col antialiased">

<div class="max-w-4xl mx-auto p-4 md:p-8 w-full flex-1">

    <div class="flex items-center justify-between mb-8">
        <a href="dashboard.php" class="flex items-center gap-2 text-slate-500 hover:text-blue-600 transition-colors group">
            <div class="p-2 bg-white rounded-xl shadow-sm group-hover:shadow-md transition-all border border-slate-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </div>
            <span class="text-sm font-bold tracking-tight">Kembali ke Dashboard</span>
        </a>
    </div>

    <div class="bg-white border border-slate-100 rounded-[2.5rem] shadow-2xl shadow-blue-900/5 overflow-hidden">
        
        <div class="h-2 bg-gradient-to-r from-blue-600 to-emerald-500"></div>

        <div class="p-8 md:p-12">
            <div class="mb-10 text-center md:text-left">
                <span class="bg-blue-50 text-blue-600 text-[10px] font-black px-4 py-2 rounded-full uppercase tracking-[0.2em]">Layanan Mandiri</span>
                <h1 class="text-3xl font-black text-slate-800 mt-4 tracking-tight">Pendaftaran Pasien</h1>
                <p class="text-slate-500 font-medium mt-2">Silakan lengkapi formulir di bawah untuk pendaftaran poliklinik.</p>
            </div>

            <form method="POST" action="proses_pendaftaran.php" class="space-y-8">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap Pasien</label>
                        <input type="text" name="nama" required placeholder="Masukkan nama sesuai KTP"
                        class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all outline-none font-medium text-slate-700">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nomor Induk Kependudukan (NIK)</label>
                        <input type="text" name="nik" required placeholder="16 Digit NIK"
                        class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all outline-none font-medium text-slate-700 font-mono">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nomor HP / WhatsApp Aktif</label>
                        <input type="text" name="no_hp" required placeholder="Contoh: 08123456789"
                        class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all outline-none font-medium text-slate-700">
                    </div>
                </div>

                <hr class="border-slate-50">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1 text-blue-600">Poliklinik Tujuan</label>
                        <div class="relative">
                            <select name="poli" required
                            class="appearance-none w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all outline-none font-bold text-slate-700 cursor-pointer">
                                <option value="" disabled selected>Pilih Poliklinik...</option>
                                <option>Poli Umum</option>
                                <option>Poli Gigi</option>
                                <option>Poli Anak</option>
                                <option>Poli Jantung</option>
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1 text-blue-600">Dokter Spesialis</label>
                        <div class="relative">
                            <select name="dokter" required
                            class="appearance-none w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all outline-none font-bold text-slate-700 cursor-pointer">
                                <option value="" disabled selected>Pilih Dokter...</option>
                                <option>Dr. Dante</option>
                                <option>Dr. Vergil</option>
                                <option>Dr. Nero</option>
                            </select>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-6">
                    <button class="group w-full bg-slate-900 text-white p-5 rounded-2xl font-black text-sm uppercase tracking-[0.2em] hover:bg-blue-600 shadow-2xl shadow-slate-200 transition-all active:scale-[0.98] flex items-center justify-center gap-3">
                        Konfirmasi Pendaftaran
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                    <p class="text-[10px] text-center text-slate-400 mt-4 font-bold italic tracking-wide uppercase">
                        Sistem akan memverifikasi data Anda secara otomatis.
                    </p>
                </div>

            </form>
        </div>
    </div>
</div>

<footer class="py-10 text-center">
    <div class="max-w-7xl mx-auto px-6">
        <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">SISTEM PENDAFTARAN RS CARUBAN • © 2026</p>
    </div>
</footer>

</body>
</html>