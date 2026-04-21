<?php
session_start();

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit;
}

$url = "https://webapi.bps.go.id/v1/api/interoperabilitas/datasource/simdasi/id/25/tahun/2025/id_tabel/a05CZmFhT0JWY0lBd2g0cW80S0xiZz09/wilayah/0000000/key/70058463cbf1a93d3592aea3ebbf1339";

$response = file_get_contents($url);
$data_bps = json_decode($response, true);

$headers = ["Provinsi"];
$columns = $data_bps['data'][1]['kolom'];
$column_keys = [];

foreach ($columns as $key => $col) {
    $headers[] = $col['nama_variabel'];
    $column_keys[] = $key;
}

$rows = [];
foreach ($data_bps['data'][1]['data'] as $item) {
    $row = [];
    $row[] = $item['label'];
    foreach ($column_keys as $key) {
        $row[] = $item['variables'][$key]['value'] ?? "-";
    }
    $rows[] = $row;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User | RS Caruban</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>

<body class="bg-[#f8fafc] text-slate-900 min-h-screen flex flex-col tracking-tight">

<div class="max-w-7xl mx-auto p-4 md:p-8 w-full flex-1">

    <header class="bg-white/80 backdrop-blur-lg sticky top-4 z-50 border border-slate-200 rounded-3xl p-4 mb-10 shadow-sm flex justify-between items-center">
        <div class="flex items-center gap-4 pl-2">
            <div class="h-10 w-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold shadow-lg shadow-blue-200">
                C
            </div>
            <div>
                <h1 class="text-lg font-bold text-slate-800 leading-none">Dashboard User</h1>
                <p class="text-slate-500 text-xs mt-1 font-medium italic opacity-80">
                    <?php echo $_SESSION['email']; ?>
                </p>
            </div>
        </div>

        <a href="logout.php" class="group flex items-center gap-2 bg-slate-100 text-slate-600 px-5 py-2.5 rounded-2xl hover:bg-red-50 hover:text-red-600 transition-all duration-300 border border-transparent hover:border-red-100">
            <span class="text-sm font-bold">Logout</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
        </a>
    </header>

    <div class="grid md:grid-cols-2 gap-6 mb-10">
        <div class="group bg-white border border-slate-200 rounded-[2rem] p-8 shadow-sm hover:shadow-xl hover:shadow-blue-500/5 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-50 rounded-full group-hover:scale-150 transition-transform duration-500 opacity-50"></div>
            <div class="relative">
                <div class="mb-4 inline-flex p-3 bg-blue-50 text-blue-600 rounded-2xl italic font-bold">🏥</div>
                <h2 class="text-xl font-bold mb-2">Pendaftaran Pasien</h2>
                <p class="text-sm text-slate-500 mb-6 leading-relaxed">Daftar sekarang untuk mendapatkan layanan kesehatan terbaik tanpa antri lama.</p>
                <a href="pendaftaran.php" class="inline-flex items-center justify-center bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold text-sm hover:bg-blue-700 shadow-lg shadow-blue-100 active:scale-95 transition-all">
                    Daftar Sekarang
                </a>
            </div>
        </div>

        <div class="group bg-white border border-slate-200 rounded-[2rem] p-8 shadow-sm hover:shadow-xl hover:shadow-emerald-500/5 hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-50 rounded-full group-hover:scale-150 transition-transform duration-500 opacity-50"></div>
            <div class="relative">
                <div class="mb-4 inline-flex p-3 bg-emerald-50 text-emerald-600 rounded-2xl italic font-bold">📋</div>
                <h2 class="text-xl font-bold mb-2">Riwayat Medis</h2>
                <p class="text-sm text-slate-500 mb-6 leading-relaxed">Pantau perkembangan kesehatanmu dengan melihat catatan riwayat kunjungan.</p>
                <a href="riwayat.php" class="inline-flex items-center justify-center bg-emerald-600 text-white px-6 py-3 rounded-2xl font-bold text-sm hover:bg-emerald-700 shadow-lg shadow-emerald-100 active:scale-95 transition-all">
                    Lihat Riwayat
                </a>
            </div>
        </div>
    </div>

    <div class="bg-indigo-50 border border-indigo-100 p-5 rounded-3xl shadow-sm flex items-start md:items-center gap-4 mb-8">
        <div class="h-10 w-10 bg-indigo-600 rounded-xl flex items-center justify-center shrink-0 shadow-lg shadow-indigo-200 text-white font-bold">
             !
        </div>
        <div class="flex-1">
            <p class="text-sm text-indigo-900 font-bold leading-tight">Verifikasi Data</p>
            <p class="text-xs md:text-sm text-indigo-700/80 font-medium mt-0.5">
                Pastikan data yang dimasukkan sudah benar sebelum dikirim untuk mempermudah sinkronisasi dengan sistem pusat RS Caruban.
            </p>
        </div>
    </div>

    <section class="bg-white border border-slate-200 rounded-[2rem] shadow-sm overflow-hidden mb-12">
        <div class="p-8 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-black text-slate-800 tracking-tight">STATISTIK PENYAKIT 2025</h2>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Sumber: Interoperabilitas BPS</p>
            </div>
            <div class="bg-slate-100 px-4 py-2 rounded-xl text-[10px] font-black text-slate-500 tracking-tighter uppercase shadow-inner">
                Update: April 2026
            </div>
        </div>

        <div class="overflow-x-auto overflow-y-auto max-h-[600px] custom-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead class="sticky top-0 z-20">
                    <tr class="bg-slate-900 shadow-md">
                        <?php foreach ($headers as $h) { ?>
                            <th class="px-6 py-5 text-[11px] font-black text-white uppercase tracking-widest border-r border-slate-800 last:border-none">
                                <div class="flex items-center gap-2">
                                    <?php echo htmlspecialchars($h); ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($rows as $row) { ?>
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <?php foreach ($row as $index => $cell) { ?>
                                <td class="px-6 py-4 text-sm <?php echo $index === 0 ? 'font-black text-blue-600 bg-slate-50/50' : 'text-slate-600 font-medium'; ?> border-r border-slate-50 last:border-none">
                                    <?php echo htmlspecialchars($cell); ?>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>

</div>

<footer class="bg-white border-t border-slate-200 py-12">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-3 gap-10 text-center md:text-left">
        <div>
            <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-4">Lokasi</h3>
            <p class="text-slate-500 text-sm leading-relaxed font-medium">Caruban, Madiun, Jawa Timur<br>Indonesia</p>
        </div>
        <div>
            <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-4">Kontak Resmi</h3>
            <p class="text-slate-500 text-sm leading-relaxed font-medium">
                Sistem Informasi: 021-912007<br>
                WhatsApp Center: 0812-2345-6789
            </p>
        </div>
        <div class="flex flex-col md:items-end justify-center">
            <div class="text-right">
                <h3 class="text-lg font-black text-blue-600 leading-none">RS CARUBAN</h3>
                <p class="text-slate-400 text-[10px] uppercase tracking-[0.2em] font-black mt-1 text-right">Integrity in Health</p>
            </div>
            <p class="text-slate-400 text-[11px] mt-6 font-medium">© 2026 RS Caruban. All Rights Reserved.</p>
        </div>
    </div>
</footer>

</body>
</html>