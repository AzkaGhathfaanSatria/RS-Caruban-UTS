<?php
session_start();

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Pendaftaran Pasien | RS Caruban</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: radial-gradient(#3b82f605 0.5px, #f8fafc 0.5px) 0 0/24px 24px; 
            overflow-x: hidden;
        }
        select { -webkit-appearance: none; -moz-appearance: none; appearance: none; }
    </style>
</head>
<body class="text-slate-900 min-h-screen flex flex-col antialiased">

<div class="max-w-4xl mx-auto p-4 md:p-8 w-full flex-1">
    <div class="mb-6 md:mb-8">
        <a href="dashboard.php" class="inline-flex items-center gap-2 text-slate-500 hover:text-blue-600 transition-all font-bold text-xs md:text-sm group">
            <div class="p-2 bg-white rounded-xl shadow-sm border border-slate-100 group-hover:bg-blue-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </div>
            Kembali
        </a>
    </div>

    <div class="bg-white border border-slate-100 rounded-[2rem] md:rounded-[2.5rem] shadow-2xl shadow-blue-900/5 overflow-hidden">
        <div class="h-2 bg-gradient-to-r from-blue-600 to-emerald-500"></div>

        <div class="p-6 md:p-12">
            <header class="mb-8 md:mb-10 text-center md:text-left">
                <span class="bg-blue-50 text-blue-600 text-[9px] md:text-[10px] font-black px-4 py-2 rounded-full uppercase tracking-widest italic">Layanan Mandiri</span>
                <h1 class="text-2xl md:text-3xl font-black text-slate-800 mt-4 tracking-tight">Pendaftaran Pasien</h1>
                <p class="text-slate-500 font-medium text-xs md:text-sm mt-1">Lengkapi form untuk mendapatkan nomor antrean.</p>
            </header>

            <form method="POST" action="proses_pendaftaran.php" class="space-y-5 md:space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Nama Pasien</label>
                        <input type="text" name="nama" required placeholder="Nama Lengkap" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 transition-all outline-none font-medium text-sm">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">NIK (16 Digit)</label>
                        <input type="text" name="nik" required inputmode="numeric" placeholder="NIK Pasien" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 transition-all outline-none font-mono text-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">No. WhatsApp</label>
                        <input type="tel" name="no_hp" required placeholder="08xxx" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 transition-all outline-none font-medium text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6 pt-4">
                    <div class="relative">
                        <label class="block text-[10px] font-black text-blue-600 uppercase tracking-widest mb-1.5 ml-1">Poli Tujuan</label>
                        <select name="poli" id="poli" onchange="updateDokter()" required class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white outline-none font-bold text-slate-700 cursor-pointer text-sm">
                            <option value="" disabled selected>Pilih Poliklinik...</option>
                            <option value="Poli Umum">Poli Umum</option>
                            <option value="Poli Gigi">Poli Gigi</option>
                            <option value="Poli Anak">Poli Anak</option>
                            <option value="Poli Jantung">Poli Jantung</option>
                        </select>
                        <div class="absolute right-4 top-[38px] pointer-events-none text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div class="relative">
                        <label class="block text-[10px] font-black text-blue-600 uppercase tracking-widest mb-1.5 ml-1">Dokter Spesialis</label>
                        <select name="dokter" id="dokter" required class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white outline-none font-bold text-slate-700 cursor-pointer text-sm">
                            <option value="" disabled selected>Pilih Poli Dahulu...</option>
                        </select>
                        <div class="absolute right-4 top-[38px] pointer-events-none text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="pt-6 md:pt-8">
                    <button type="submit" class="w-full bg-slate-900 text-white p-4 md:p-5 rounded-2xl md:rounded-[2rem] font-black text-[10px] md:text-xs uppercase tracking-[0.2em] hover:bg-blue-600 transition-all shadow-xl active:scale-95 flex items-center justify-center gap-3">
                        Daftar Sekarang
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                    <p class="text-center text-[9px] text-slate-400 mt-4 font-bold uppercase tracking-widest">Estimasi antrean akan dikirim via WhatsApp</p>
                </div>
            </form>
        </div>
    </div>
</div>

<footer class="py-8 text-center">
    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">SISTEM RS CARUBAN • © 2026</p>
</footer>

<script>
const dataDokter = {
    "Poli Umum": ["Dr. Dante Sp.PD", "Dr. Vergil Sp.PD", "Dr. Nero Sp.PD"],
    "Poli Gigi": ["Drg. Leon", "Drg. Chris", "Drg. Ethan"],
    "Poli Anak": ["Dr. Joel Sp.A", "Dr. Ellie Sp.A", "Dr. Tommy Sp.A"],
    "Poli Jantung": ["Dr. Morgana Sp.JP", "Dr. Koromaru Sp.JP", "Dr. Teddie Sp.JP"]
};

function updateDokter() {
    const poliSelect = document.getElementById('poli');
    const dokterSelect = document.getElementById('dokter');
    const poliTerpilih = poliSelect.value;

    dokterSelect.innerHTML = '<option value="" disabled selected>Pilih Dokter...</option>';

    if (dataDokter[poliTerpilih]) {
        dataDokter[poliTerpilih].forEach(dokter => {
            let option = document.createElement('option');
            option.value = dokter;
            option.text = dokter;
            dokterSelect.add(option);
        });
    }
}
</script>

</body>
</html>