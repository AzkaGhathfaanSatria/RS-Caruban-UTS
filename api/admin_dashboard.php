<?php
session_start();
include 'koneksi.php';
$conn = $koneksi ?? $conn;

// Metode pengecekan persis dashboard user (Anti-Mental)
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// 1. Ambil data user sekaligus (Efisien: Cukup 1 Query Utama)
$data_user = mysqli_query($conn, "SELECT * FROM user ORDER BY role ASC");
$total_user = mysqli_num_rows($data_user);

// 2. Hitung statistik dari hasil query (Lebih cepat daripada bolak-balik ke DB)
$total_admin = 0;
$total_user_biasa = 0;
$users_array = [];

while ($row = mysqli_fetch_assoc($data_user)) {
    $users_array[] = $row;
    if ($row['role'] == 'admin') $total_admin++;
    else $total_user_biasa++;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | RS Caruban</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>

<body class="bg-[#fcfcfd] text-slate-900 min-h-screen antialiased">
<div class="max-w-7xl mx-auto p-4 md:p-8">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
        <div>
            <h1 class="text-2xl md:text-3xl font-black tracking-tight text-slate-900">Admin Control Center</h1>
            <p class="text-slate-500 font-medium mt-1 flex items-center gap-2 text-sm">
                <span class="inline-block w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                Login sebagai: <span class="font-bold text-slate-700"><?= $_SESSION['email']; ?></span>
            </p>
        </div>
        <a href="logout.php" class="bg-white border border-slate-200 text-slate-600 px-6 py-2.5 rounded-2xl hover:bg-red-50 hover:text-red-600 transition-all font-bold text-sm shadow-sm">Logout</a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">
        <?php 
        $stats = [
            ['Total User', $total_user, 'blue', '👥'],
            ['User Biasa', $total_user_biasa, 'emerald', '👤'],
            ['Admin', $total_admin, 'rose', '🛡️']
        ];
        foreach ($stats as $s) : ?>
        <div class="bg-white border border-slate-200 rounded-[2rem] p-7 shadow-sm group relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-<?= $s[2] ?>-50 rounded-full group-hover:scale-125 transition-all"></div>
            <div class="relative">
                <div class="text-2xl mb-4"><?= $s[3] ?></div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest"><?= $s[0] ?></p>
                <h3 class="text-3xl font-black text-slate-900 mt-1"><?= $s[1] ?></h3>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="bg-white border border-slate-200 rounded-[2.5rem] shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="text-xl font-black text-slate-800">Database Personil</h2>
            <a href="tambah_admin.php" class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold text-sm hover:bg-blue-700 shadow-lg shadow-blue-100 transition-all">+ Tambah Admin</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-widest">Identitas</th>
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-widest">NIK</th>
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-widest">Role</th>
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($users_array as $u) : ?>
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-8 py-6">
                            <div class="font-bold text-slate-700 text-sm"><?= $u['email'] ?></div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="font-mono text-xs bg-slate-100 px-2 py-1 rounded text-slate-500 font-bold"><?= $u['nik'] ?></span>
                        </td>
                        <td class="px-8 py-6">
                            <?php $isAdmin = ($u['role'] == 'admin'); ?>
                            <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase border <?= $isAdmin ? 'bg-rose-50 text-rose-600 border-rose-100' : 'bg-emerald-50 text-emerald-600 border-emerald-100' ?>">
                                <?= $isAdmin ? 'Administrator' : 'Reguler User' ?>
                            </span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <div class="flex justify-center gap-3">
                                <a href="ubah_role.php?id=<?= $u['id'] ?>" class="text-amber-500 hover:scale-110 transition-transform">✏️</a>
                                <a href="hapus_user.php?id=<?= $u['id'] ?>" onclick="return confirm('Hapus user?')" class="text-rose-500 hover:scale-110 transition-transform">🗑️</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>