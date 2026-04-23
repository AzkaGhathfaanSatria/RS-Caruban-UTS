<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$email_user_login = $_SESSION['email'];

$query = mysqli_query($conn, "SELECT * FROM pasien WHERE email='$email_user_login' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Saya | RS Caruban</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<body class="bg-[#f8fafc] min-h-screen flex flex-col antialiased">

<nav class="bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <div class="p-1.5 bg-blue-600 rounded-lg shadow-lg shadow-blue-100">
                <img src="RS Caruban.png" class="w-5 brightness-0 invert" alt="Logo">
            </div>
            <span class="font-black text-slate-800 tracking-tight uppercase">RS CARUBAN</span>
        </div>

        <a href="dashboard.php" class="flex items-center gap-2 bg-slate-50 border border-slate-200 text-slate-600 px-4 py-2 rounded-xl hover:bg-blue-600 hover:text-white hover:border-blue-600 transition-all font-bold text-xs shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            Dashboard
        </a>
    </div>
</nav>

<div class="max-w-7xl mx-auto p-6 w-full flex-1">

    <div class="mb-8">
        <span class="text-blue-600 text-[10px] font-black uppercase tracking-[0.3em]">Aktivitas Pasien</span>
        <h2 class="text-3xl font-black text-slate-800 tracking-tight mt-1">Riwayat Pendaftaran</h2>
        <p class="text-slate-500 font-medium mt-1">Hanya menampilkan data pendaftaran milik Anda.</p>
    </div>

    <div class="bg-white border border-slate-100 rounded-[2.5rem] shadow-2xl shadow-blue-900/5 overflow-hidden">
        
        <?php if (mysqli_num_rows($query) == 0) { ?>
            <div class="py-24 text-center">
                <div class="inline-flex p-6 bg-slate-50 rounded-full mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">Belum Ada Riwayat Ditemukan</p>
                <a href="pendaftaran.php" class="inline-block mt-6 bg-blue-600 text-white px-6 py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-blue-700 transition-all shadow-lg shadow-blue-100">Daftar Sekarang</a>
            </div>
        <?php } else { ?>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Data Pasien</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Unit Layanan</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Dokter</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Waktu Daftar</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-50">
                        <?php while ($data = mysqli_fetch_assoc($query)) { ?>
                            <tr class="hover:bg-slate-50/30 transition-colors group">
                                <td class="px-8 py-6">
                                    <div class="font-bold text-slate-800 text-sm group-hover:text-blue-600 transition-colors"><?php echo $data['nama']; ?></div>
                                    <div class="text-[10px] text-slate-400 font-mono mt-1 tracking-wider"><?php echo $data['nik']; ?></div>
                                </td>
                                <td class="px-8 py-6">
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg bg-blue-50 text-blue-600 text-[11px] font-black uppercase">
                                        <?php echo $data['poli']; ?>
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-sm text-slate-600 font-semibold italic">
                                    <?php echo $data['dokter']; ?>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-sm font-bold text-slate-700"><?php echo date('d M Y', strtotime($data['tanggal'])); ?></div>
                                    <div class="text-[10px] text-slate-400 font-medium">Jam Terdaftar Sistem</div>
                                </td>
                                <td class="px-8 py-6 text-center">
                                    <span class="px-4 py-2 rounded-xl bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest border border-emerald-100">
                                        Sudah Verifikasi
                                    </span>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php } ?>
    </div>
</div>

<footer class="py-10 text-center">
    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em]">SISTEM RIWAYAT TERPADU • RS CARUBAN • 2026</p>
</footer>

</body>
</html>