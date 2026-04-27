<?php
session_start();
$isLogin = isset($_SESSION['login']) || (isset($_COOKIE['user_login']) && $_COOKIE['user_login'] === 'true');
if (!$isLogin) { header("Location: login.php"); exit(); }

$nama_default = $_SESSION['nama_akun'] ?? $_COOKIE['user_nama'] ?? '';
$nik_default  = $_SESSION['nik_akun'] ?? $_COOKIE['user_nik'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pasien | RS Caruban</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-50 font-['Plus_Jakarta_Sans'] min-h-screen flex flex-col antialiased">
<div class="max-w-4xl mx-auto p-4 md:p-8 w-full">
    <div class="mb-6"><a href="dashboard.php" class="text-slate-500 font-bold text-sm">← Kembali</a></div>
    <div class="bg-white rounded-[2.5rem] shadow-xl overflow-hidden border border-slate-100">
        <div class="h-2 bg-gradient-to-r from-blue-600 to-emerald-500"></div>
        <div class="p-8 md:p-12">
            <header class="mb-10 text-center md:text-left">
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">Pendaftaran Pasien</h1>
                <p class="text-slate-500 text-sm mt-1">Data Nama & NIK terisi otomatis sesuai akun Anda.</p>
            </header>
            <form method="POST" action="proses_pendaftaran.php" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Nama Pasien</label>
                        <input type="text" name="nama" required value="<?= $nama_default ?>" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white outline-none font-medium text-sm">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">NIK (16 Digit)</label>
                        <input type="text" name="nik" required value="<?= $nik_default ?>" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white outline-none font-mono text-sm">
                    </div>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">No. WhatsApp</label>
                    <input type="tel" name="no_hp" required placeholder="08xxx" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white outline-none font-medium text-sm">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <select name="poli" id="poli" onchange="updateDokter()" required class="w-full bg-slate-50 border p-4 rounded-2xl font-bold text-sm">
                        <option value="" disabled selected>Pilih Poliklinik...</option>
                        <option value="Poli Umum">Poli Umum</option>
                        <option value="Poli Gigi">Poli Gigi</option>
                        <option value="Poli Anak">Poli Anak</option>
                    </select>
                    <select name="dokter" id="dokter" required class="w-full bg-slate-50 border p-4 rounded-2xl font-bold text-sm">
                        <option value="" disabled selected>Pilih Dokter...</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-slate-900 text-white p-5 rounded-[2rem] font-black text-xs uppercase tracking-[0.2em] hover:bg-blue-600 transition-all">Daftar Sekarang</button>
            </form>
        </div>
    </div>
</div>
<script>
const dataDokter = { "Poli Umum": ["Dr. Dante Sp.PD", "Dr. Vergil Sp.PD"], "Poli Gigi": ["Drg. Leon", "Drg. Chris"], "Poli Anak": ["Dr. Joel Sp.A", "Dr. Ellie Sp.A"] };
function updateDokter() {
    const poli = document.getElementById('poli').value;
    const dokterSelect = document.getElementById('dokter');
    dokterSelect.innerHTML = '<option value="" disabled selected>Pilih Dokter...</option>';
    if (dataDokter[poli]) {
        dataDokter[poli].forEach(d => {
            let opt = document.createElement('option'); opt.value = d; opt.text = d; dokterSelect.add(opt);
        });
    }
}
</script>
</body>
</html>