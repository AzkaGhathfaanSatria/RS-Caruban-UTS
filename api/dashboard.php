<?php
session_start();

// 1. Sinkronisasi & Proteksi Session/Cookie
$isLogin = isset($_SESSION['login']) || (isset($_COOKIE['user_login']) && $_COOKIE['user_login'] === 'true');
$role    = $_SESSION['role'] ?? $_COOKIE['user_role'] ?? '';
$email   = $_SESSION['email'] ?? $_COOKIE['user_email'] ?? 'User';

if (!$isLogin || $role !== 'user') {
    header("Location: login.php");
    exit();
}

// 2. Fetch Data BPS (Optimized Hybrid)
$url = "https://webapi.bps.go.id/v1/api/interoperabilitas/datasource/simdasi/id/25/tahun/2025/id_tabel/a05CZmFhT0JWY0lBd2g0cW80S0xiZz09/wilayah/0000000/key/70058463cbf1a93d3592aea3ebbf1339";
$res = false;

if (function_exists('curl_init')) {
    $ch = curl_init($url);
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => 1, CURLOPT_TIMEOUT => 10, CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_USERAGENT => 'Mozilla/5.0']);
    $res = curl_exec($ch);
    curl_close($ch);
} 

if (!$res) {
    $res = @file_get_contents($url, false, stream_context_create(["http" => ["method" => "GET", "header" => "User-Agent: Mozilla/5.0\r\n", "timeout" => 10]]));
}

$data_bps = json_decode($res, true);
$headers = ["Provinsi"]; $rows = [];

if (isset($data_bps['data'][1])) {
    $cols = $data_bps['data'][1]['kolom'];
    $keys = array_keys($cols);
    foreach ($cols as $col) $headers[] = $col['nama_variabel'];
    foreach ($data_bps['data'][1]['data'] as $item) {
        $r = [$item['label']];
        foreach ($keys as $k) $r[] = $item['variables'][$k]['value'] ?? "-";
        $rows[] = $r;
    }
} else {
    $headers[] = "Info"; $rows[] = ["-", "Data tidak dapat dimuat dari server BPS."];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User | RS Caruban</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-900 min-h-screen flex flex-col tracking-tight">

<div class="max-w-7xl mx-auto p-4 md:p-8 w-full flex-1">
    <header class="bg-white/80 backdrop-blur-lg sticky top-4 z-50 border border-slate-200 rounded-3xl p-4 mb-10 shadow-sm flex justify-between items-center">
        <div class="flex items-center gap-4 pl-2">
            <div class="h-10 w-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg shadow-blue-200">C</div>
            <div>
                <h1 class="text-lg font-bold text-slate-800 leading-none">Dashboard User</h1>
                <p class="text-slate-500 text-xs mt-1 font-medium opacity-80"><?= htmlspecialchars($email) ?></p>
            </div>
        </div>
        <a href="logout.php" class="flex items-center gap-2 bg-slate-100 text-slate-600 px-5 py-2.5 rounded-2xl hover:bg-red-50 hover:text-red-600 transition-all font-bold text-sm">Logout</a>
    </header>

    <div class="grid md:grid-cols-2 gap-6 mb-10">
        <?php 
        $cards = [
            ['🏥', 'Pendaftaran Pasien', 'Daftar layanan kesehatan terbaik tanpa antri.', 'pendaftaran.php', 'blue'],
            ['📋', 'Riwayat Medis', 'Pantau catatan riwayat kunjungan kesehatanmu.', 'riwayat.php', 'emerald']
        ];
        foreach ($cards as $c): ?>
        <div class="bg-white border border-slate-200 rounded-[2rem] p-8 shadow-sm hover:-translate-y-1 transition-all group overflow-hidden relative">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-<?= $c[4] ?>-50 rounded-full group-hover:scale-150 transition-all opacity-50"></div>
            <div class="relative">
                <div class="mb-4 inline-flex p-3 bg-<?= $c[4] ?>-50 text-<?= $c[4] ?>-600 rounded-2xl font-bold"><?= $c[0] ?></div>
                <h2 class="text-xl font-bold mb-2"><?= $c[1] ?></h2>
                <p class="text-sm text-slate-500 mb-6"><?= $c[2] ?></p>
                <a href="<?= $c[3] ?>" class="inline-flex bg-<?= $c[4] ?>-600 text-white px-6 py-3 rounded-2xl font-bold text-sm hover:opacity-90 shadow-lg shadow-<?= $c[4] ?>-100 active:scale-95 transition-all">Buka Layanan</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="bg-indigo-50 border border-indigo-100 p-5 rounded-3xl flex items-center gap-4 mb-8">
        <div class="h-10 w-10 bg-indigo-600 rounded-xl flex items-center justify-center shrink-0 text-white font-bold shadow-lg">!</div>
        <p class="text-xs md:text-sm text-indigo-900 font-medium">Pastikan data yang dimasukkan benar untuk sinkronisasi sistem pusat RS Caruban.</p>
    </div>

    <section class="bg-white border border-slate-200 rounded-[2rem] shadow-sm overflow-hidden mb-12">
        <div class="p-8 border-b border-slate-100 flex justify-between items-center">
            <div>
                <h2 class="text-xl font-black text-slate-800 tracking-tight uppercase">Statistik Penyakit 2025</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Sumber: BPS</p>
            </div>
            <div class="bg-slate-100 px-4 py-2 rounded-xl text-[10px] font-black text-slate-500 uppercase shadow-inner">Update: 2026</div>
        </div>
        <div class="overflow-x-auto max-h-[600px] custom-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead class="sticky top-0 z-20 bg-slate-900 shadow-md">
                    <tr>
                        <?php foreach ($headers as $h): ?>
                        <th class="px-6 py-5 text-[11px] font-black text-white uppercase tracking-widest border-r border-slate-800"><?= htmlspecialchars($h) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($rows)): ?>
                        <tr><td colspan="100%" class="p-10 text-center text-slate-400 font-medium">Data tidak tersedia...</td></tr>
                    <?php else: foreach ($rows as $row): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <?php foreach ($row as $i => $cell): ?>
                            <td class="px-6 py-4 text-sm <?= $i === 0 ? 'font-black text-blue-600 bg-slate-50/50' : 'text-slate-600 font-medium' ?> border-r border-slate-50"><?= htmlspecialchars($cell) ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<footer class="bg-white border-t border-slate-200 py-12">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-10 items-center">
        <div><h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-2">Lokasi</h3><p class="text-slate-500 text-sm">Caruban, Madiun, Jawa Timur</p></div>
        <div><h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-2">Kontak</h3><p class="text-slate-500 text-sm">IS: 021-912007 | WA: 0812-2345-6789</p></div>
        <div class="md:text-right">
            <h3 class="text-lg font-black text-blue-600">RS CARUBAN</h3>
            <p class="text-slate-400 text-[11px] mt-2 font-medium">© 2026 Integrity in Health.</p>
        </div>
    </div>
</footer>
</body>
</html>