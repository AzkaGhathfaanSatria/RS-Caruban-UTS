<?php
session_start();

// 1. Perbaikan: Cek session dengan benar
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: /index.html");
    exit;
}

$current_role = isset($_SESSION['role']) ? strtolower(trim($_SESSION['role'])) : '';
if ($current_role !== 'user') {
    header("Location: /index.html");
    exit;
}

// 2. Data API BPS (Tetap Sama)
$url = "https://webapi.bps.go.id/v1/api/interoperabilitas/datasource/simdasi/id/25/tahun/2025/id_tabel/a05CZmFhT0JWY0lBd2g0cW80S0xiZz09/wilayah/0000000/key/70058463cbf1a93d3592aea3ebbf1339";

$opts = ["http" => ["header" => "User-Agent: PHP\r\n"]];
$context = stream_context_create($opts);
$response = @file_get_contents($url, false, $context);

$headers = ["Provinsi"];
$rows = [];

if ($response !== FALSE) {
    $data_bps = json_decode($response, true);
    $main_data = null;
    if (isset($data_bps['data']) && is_array($data_bps['data'])) {
        foreach ($data_bps['data'] as $item_check) {
            if (isset($item_check['kolom']) && isset($item_check['data'])) {
                $main_data = $item_check;
                break;
            }
        }
    }

    if ($main_data) {
        $columns = $main_data['kolom'];
        $column_keys = [];
        foreach ($columns as $key => $col) {
            $headers[] = $col['nama_variabel'];
            $column_keys[] = $key;
        }
        $raw_data = $main_data['data'];
        foreach ($raw_data as $item) {
            $row = [$item['label']];
            foreach ($column_keys as $key) {
                $row[] = $item['variables'][$key]['value'] ?? "-";
            }
            $rows[] = $row;
        }
    } else {
        $headers = ["Info"];
        $rows = [["Struktur data API tidak sesuai"]];
    }
} else {
    $headers = ["Error"];
    $rows = [["Gagal terhubung ke server BPS"]];
}
// 3. Perbaikan: WAJIB tutup tag PHP sebelum HTML
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User | RS Caruban</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="bg-[#f8fafc] text-slate-900 min-h-screen flex flex-col tracking-tight">

<div class="max-w-7xl mx-auto p-4 md:p-8 w-full flex-1">
    <header class="bg-white/80 backdrop-blur-lg sticky top-4 z-50 border border-slate-200 rounded-3xl p-4 mb-10 shadow-sm flex justify-between items-center">
        <div class="flex items-center gap-4 pl-2">
            <div class="h-10 w-10 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold">C</div>
            <div>
                <h1 class="text-lg font-bold text-slate-800 leading-none">Dashboard User</h1>
                <p class="text-slate-500 text-xs mt-1 font-medium italic opacity-80">
                    <?php echo htmlspecialchars($_SESSION['email'] ?? 'User'); ?>
                </p>
            </div>
        </div>
        <a href="/api/logout.php" class="bg-slate-100 text-slate-600 px-5 py-2.5 rounded-2xl hover:bg-red-50 hover:text-red-600 transition-all text-sm font-bold">Logout</a>
    </header>

    <div class="grid md:grid-cols-2 gap-6 mb-10">
        <div class="bg-white border border-slate-200 rounded-[2rem] p-8 shadow-sm">
            <h2 class="text-xl font-bold mb-2">Pendaftaran Pasien</h2>
            <p class="text-sm text-slate-500 mb-6">Daftar sekarang untuk mendapatkan layanan kesehatan terbaik.</p>
            <a href="/api/pendaftaran.php" class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold text-sm">Daftar Sekarang</a>
        </div>
        <div class="bg-white border border-slate-200 rounded-[2rem] p-8 shadow-sm">
            <h2 class="text-xl font-bold mb-2">Riwayat Medis</h2>
            <p class="text-sm text-slate-500 mb-6">Pantau perkembangan kesehatanmu melalui riwayat kunjungan.</p>
            <a href="/api/riwayat.php" class="bg-emerald-600 text-white px-6 py-3 rounded-2xl font-bold text-sm">Lihat Riwayat</a>
        </div>
    </div>

    <section class="bg-white border border-slate-200 rounded-[2rem] shadow-sm overflow-hidden mb-12">
        <div class="p-8 border-b border-slate-100">
            <h2 class="text-xl font-black text-slate-800 tracking-tight uppercase">STATISTIK PENYAKIT 2025</h2>
            <p class="text-xs text-slate-400 font-bold uppercase mt-1">Sumber: Interoperabilitas BPS</p>
        </div>

        <div class="overflow-x-auto overflow-y-auto max-h-[600px] custom-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead class="sticky top-0 z-20">
                    <tr class="bg-slate-900 shadow-md">
                        <?php foreach ($headers as $h): ?>
                            <th class="px-6 py-5 text-[11px] font-black text-white uppercase tracking-widest border-r border-slate-800 last:border-none">
                                <?php echo htmlspecialchars($h); ?>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($rows)): ?>
                        <tr><td colspan="100%" class="p-10 text-center text-slate-400 italic">Data sedang memuat atau tidak tersedia.</td></tr>
                    <?php else: ?>
                        <?php foreach ($rows as $row): ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <?php foreach ($row as $index => $cell): ?>
                                    <td class="px-6 py-4 text-sm <?php echo $index === 0 ? 'font-black text-blue-600 bg-slate-50/50' : 'text-slate-600 font-medium'; ?> border-r border-slate-50 last:border-none">
                                        <?php echo htmlspecialchars($cell); ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<footer class="bg-white border-t border-slate-200 py-12 text-center text-slate-400 text-xs">
    <p>© 2026 RS Caruban. All Rights Reserved.</p>
</footer>

</body>
</html>