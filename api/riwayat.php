<?php
session_start();
require_once 'koneksi.php';
$conn = $koneksi ?? $conn;

$isLogin = isset($_SESSION['login']) || (isset($_COOKIE['user_login']) && $_COOKIE['user_login'] === 'true');
$role    = $_SESSION['role'] ?? $_COOKIE['user_role'] ?? '';
$email   = $_SESSION['email'] ?? $_COOKIE['user_email'] ?? '';

if (!$isLogin || $role !== 'user') {
    header("Location: login.php");
    exit();
}

$query = mysqli_query($conn, "SELECT * FROM pasien WHERE email='$email' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Riwayat Saya | RS Caruban</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media (max-width: 768px) {
            .responsive-table thead { display: none; }
            .responsive-table tr { 
                display: block; 
                margin-bottom: 1rem; 
                border: 1px solid #f1f5f9; 
                border-radius: 1.5rem;
                padding: 1rem;
                background: white;
            }
            .responsive-table td { 
                display: flex; 
                justify-content: space-between; 
                padding: 0.5rem 0; 
                border: none !important;
                text-align: right;
            }
            .responsive-table td::before {
                content: attr(data-label);
                font-weight: 800;
                text-transform: uppercase;
                font-size: 10px;
                color: #94a3b8;
                text-align: left;
            }
        }
    </style>
</head>

<body class="bg-[#f8fafc] min-h-screen flex flex-col antialiased text-slate-900">

<nav class="bg-white/80 backdrop-blur-md border-b border-slate-100 sticky top-0 z-50 px-4 md:px-6 py-4">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <div class="flex items-center gap-2 font-black tracking-tighter text-blue-600 uppercase text-sm md:text-base">RS Caruban</div>
        <a href="dashboard.php" class="text-[10px] md:text-xs font-bold bg-slate-50 px-4 py-2 rounded-xl border border-slate-200 hover:bg-blue-600 hover:text-white transition-all">Dashboard</a>
    </div>
</nav>

<main class="max-w-7xl mx-auto p-4 md:p-8 w-full flex-1">
    <header class="mb-6 md:mb-8">
        <span class="text-blue-600 text-[10px] font-black uppercase tracking-[0.3em]">Aktivitas</span>
        <h2 class="text-2xl md:text-3xl font-black tracking-tight mt-1">Riwayat Pendaftaran</h2>
        <p class="text-slate-500 text-xs md:text-sm font-medium">Data kunjungan kesehatan Anda.</p>
    </header>

    <div class="md:bg-white md:border md:border-slate-100 md:rounded-[2.5rem] md:shadow-2xl md:shadow-blue-900/5 overflow-hidden">
        <?php if (mysqli_num_rows($query) == 0) : ?>
            <div class="py-20 md:py-24 text-center bg-white rounded-[2.5rem] border border-slate-100 shadow-sm">
                <div class="text-4xl mb-4">📂</div>
                <p class="text-slate-400 font-bold uppercase tracking-widest text-[10px]">Belum Ada Riwayat Kunjungan</p>
                <a href="pendaftaran.php" class="inline-block mt-6 bg-blue-600 text-white px-8 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest shadow-lg shadow-blue-100 transition-all active:scale-95">Daftar Sekarang</a>
            </div>
        <?php else : ?>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse responsive-table">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Waktu Daftar</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pasien</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Poli</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Dokter</th>
                            <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 md:bg-transparent">
                        <?php while ($data = mysqli_fetch_assoc($query)) : ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-8 py-6" data-label="Waktu Daftar">
                                    <div class="flex flex-col items-end md:items-start">
                                        <div class="font-bold text-xs text-blue-600">
                                            <?= date('d M Y', strtotime($data['tanggal'])) ?>
                                        </div>
                                        <div class="text-[10px] text-slate-400 font-medium">
                                            <?= date('H:i', strtotime($data['tanggal'])) ?> WIB
                                        </div>
                                    </div>
                                </td>

                                <td class="px-8 py-6" data-label="Pasien">
                                    <div class="flex flex-col items-end md:items-start">
                                        <div class="font-bold text-sm text-slate-800"><?= htmlspecialchars($data['nama']) ?></div>
                                        <div class="text-[10px] text-slate-400 font-mono italic">NIK: <?= htmlspecialchars($data['nik']) ?></div>
                                    </div>
                                </td>
                                <td class="px-8 py-6" data-label="Poli">
                                    <span class="px-3 py-1 rounded-lg bg-blue-50 text-blue-600 text-[10px] font-black uppercase"><?= $data['poli'] ?></span>
                                </td>
                                <td class="px-8 py-6" data-label="Dokter">
                                    <span class="text-xs font-semibold text-slate-600 italic"><?= $data['dokter'] ?></span>
                                </td>
                                <td class="px-8 py-6 text-center" data-label="Status">
                                    <span class="px-4 py-2 rounded-xl bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase border border-emerald-100">Terverifikasi</span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</main>

<footer class="py-10 text-center">
    <p class="text-slate-400 text-[9px] md:text-[10px] font-black uppercase tracking-widest">SISTEM RS CARUBAN • 2026</p>
</footer>

</body>
</html>