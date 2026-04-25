<?php
// 1. Session & Cookie Setup (Wajib di Vercel agar tidak mental)
session_set_cookie_params(0, '/'); 
session_start();
include 'koneksi.php';

// 2. Proteksi Login (Aktifkan kembali dengan pengecekan VARCHAR yang aman)
if (!isset($_SESSION['login'])) {
    header("Location: /index.html");
    exit;
}

// Pastikan yang masuk ke sini HANYA user (atau admin juga boleh lihat dashboard ini)
$role = isset($_SESSION['role']) ? strtolower(trim($_SESSION['role'])) : '';
$email_user = $_SESSION['email'];


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | RS Caruban</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>

<body class="bg-[#f8fafc] text-slate-900 min-h-screen flex flex-col antialiased">

<div class="max-w-7xl mx-auto p-4 md:p-8 w-full flex-1">

    <header class="bg-white/80 backdrop-blur-lg sticky top-4 z-50 border border-slate-200 rounded-[2rem] p-4 mb-10 shadow-sm flex justify-between items-center px-6">
        <div class="flex items-center gap-4">
            <div class="h-10 w-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-black shadow-lg shadow-blue-200">R</div>
            <div>
                <h1 class="text-sm font-black text-slate-800 leading-none uppercase tracking-tighter">RS Caruban Digital</h1>
                <p class="text-[10px] text-blue-600 mt-1 font-bold italic"><?php echo htmlspecialchars($email_user); ?></p>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <?php if ($role === 'admin') : ?>
                <a href="/api/admin_dashboard.php" class="text-[10px] font-black bg-amber-100 text-amber-700 px-4 py-2 rounded-xl border border-amber-200 hover:bg-amber-200 transition-all">PANEL ADMIN</a>
            <?php endif; ?>
            <a href="/api/logout.php" class="text-[10px] font-black bg-red-50 text-red-600 px-4 py-2 rounded-xl border border-red-100 hover:bg-red-600 hover:text-white transition-all">LOGOUT</a>
        </div>
    </header>

    <div class="grid md:grid-cols-2 gap-6 mb-12">
        <a href="/api/pendaftaran.php" class="group bg-white border border-slate-200 rounded-[2.5rem] p-8 shadow-sm hover:shadow-xl hover:shadow-blue-500/5 transition-all duration-300 relative overflow-hidden">
            <div class="relative z-10">
                <div class="mb-4 inline-flex p-4 bg-blue-50 text-blue-600 rounded-2xl text-2xl">🏥</div>
                <h2 class="text-xl font-black mb-1 group-hover:text-blue-600 transition-colors">Pendaftaran Pasien</h2>
                <p class="text-sm text-slate-500 mb-6 font-medium">Daftar layanan poliklinik secara instan.</p>
                <span class="text-[10px] font-black uppercase tracking-widest text-blue-600 bg-blue-50 px-4 py-2 rounded-full">Buka Formulir →</span>
            </div>
        </a>

        <a href="/api/riwayat.php" class="group bg-white border border-slate-200 rounded-[2.5rem] p-8 shadow-sm hover:shadow-xl hover:shadow-emerald-500/5 transition-all duration-300 relative overflow-hidden">
            <div class="relative z-10">
                <div class="mb-4 inline-flex p-4 bg-emerald-50 text-emerald-600 rounded-2xl text-2xl">📋</div>
                <h2 class="text-xl font-black mb-1 group-hover:text-emerald-600 transition-colors">Riwayat Medis</h2>
                <p class="text-sm text-slate-500 mb-6 font-medium">Pantau status pendaftaran dan antrian Anda.</p>
                <span class="text-[10px] font-black uppercase tracking-widest text-emerald-600 bg-emerald-50 px-4 py-2 rounded-full">Cek Riwayat →</span>
            </div>
        </a>
    </div>

    <section class="bg-white border border-slate-200 rounded-[2.5rem] shadow-sm overflow-hidden mb-12">
        <div class="p-8 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50/50">
            <div>
                <h2 class="text-xl font-black text-slate-800 tracking-tight">DATA KESEHATAN NASIONAL 2025</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">SINKRONISASI REAL-TIME BPS INDONESIA</p>
            </div>
        </div>

        <div class="overflow-x-auto max-h-[500px] custom-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead class="sticky top-0 z-20">
                    <tr class="bg-slate-900">
                        <?php foreach ($headers as $h) { ?>
                            <th class="px-6 py-5 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] border-r border-slate-800 last:border-none">
                                <?php echo htmlspecialchars($h); ?>
                            </th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($rows)): ?>
                        <tr><td colspan="100%" class="p-20 text-center text-slate-400 font-bold uppercase text-xs tracking-widest">Gagal memuat data statistik...</td></tr>
                    <?php else: ?>
                        <?php foreach ($rows as $row) { ?>
                            <tr class="hover:bg-blue-50/30 transition-colors">
                                <?php foreach ($row as $index => $cell) { ?>
                                    <td class="px-6 py-4 text-xs <?php echo $index === 0 ? 'font-black text-blue-600 bg-slate-50/30' : 'text-slate-600 font-semibold'; ?> border-r border-slate-50 last:border-none">
                                        <?php echo htmlspecialchars($cell); ?>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<footer class="py-12 text-center">
    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.3em]">Integrity in Health • RS Caruban • 2026</p>
</footer>

</body>
</html>