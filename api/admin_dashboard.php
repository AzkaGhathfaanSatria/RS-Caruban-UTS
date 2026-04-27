<?php
ob_start();
session_start();
include 'koneksi.php';
$conn = $koneksi ?? $conn;

if (!isset($_SESSION['login']) && isset($_COOKIE['user_login'])) {
    $_SESSION['login'] = true;
    $_SESSION['role']  = $_COOKIE['user_role'];
    $_SESSION['email'] = $_COOKIE['user_email'];
}

$role_check = $_SESSION['role'] ?? '';
if (!isset($_SESSION['login']) || $role_check !== 'admin') {
    header("Location: login.php");
    exit();
}

$data_user = mysqli_query($conn, "SELECT * FROM user ORDER BY role ASC");
$users_array = [];
$total_admin = 0;
$total_user_biasa = 0;

while ($row = mysqli_fetch_assoc($data_user)) {
    $users_array[] = $row;
    if ($row['role'] == 'admin') $total_admin++;
    else $total_user_biasa++;
}
$total_user = count($users_array);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Admin Panel | RS Caruban</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; overflow-x: hidden; }
        /* Custom Scrollbar untuk Tabel */
        .custom-scroll::-webkit-scrollbar { height: 4px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    </style>
</head>

<body class="bg-[#fcfcfd] text-slate-900 min-h-screen antialiased">
<div class="max-w-7xl mx-auto p-4 md:p-8">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8 md:mb-10">
        <div class="w-full md:w-auto">
            <h1 class="text-2xl md:text-3xl font-black tracking-tight text-slate-900">Admin Control</h1>
            <p class="text-slate-500 font-medium mt-1 flex items-center gap-2 text-xs md:text-sm">
                <span class="inline-block w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                <span class="opacity-70 text-nowrap truncate max-w-[200px] md:max-w-full">Admin: <?= $_SESSION['email']; ?></span>
            </p>
        </div>
        <a href="logout.php" class="w-full md:w-auto text-center bg-white border border-slate-200 text-slate-600 px-6 py-2.5 rounded-xl md:rounded-2xl hover:bg-red-50 hover:text-red-600 transition-all font-bold text-sm shadow-sm active:scale-95">Logout</a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6 mb-8 md:mb-12">
        <?php 
        $stats = [
            ['Total User', $total_user, 'blue', '👥'],
            ['User Biasa', $total_user_biasa, 'emerald', '👤'],
            ['Admin', $total_admin, 'rose', '🛡️']
        ];
        foreach ($stats as $s) : ?>
        <div class="bg-white border border-slate-200 rounded-[1.5rem] md:rounded-[2rem] p-6 md:p-7 shadow-sm group relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-<?= $s[2] ?>-50 rounded-full group-hover:scale-125 transition-all"></div>
            <div class="relative flex items-center md:block gap-4">
                <div class="text-2xl md:mb-4 bg-<?= $s[2] ?>-50 w-12 h-12 flex items-center justify-center rounded-xl"><?= $s[3] ?></div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest"><?= $s[0] ?></p>
                    <h3 class="text-2xl md:text-3xl font-black text-slate-900 mt-0.5"><?= $s[1] ?></h3>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="bg-white border border-slate-200 rounded-[1.5rem] md:rounded-[2.5rem] shadow-sm overflow-hidden">
        <div class="p-6 md:p-8 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-lg md:text-xl font-black text-slate-800">Database Personil</h2>
            <a href="tambah_admin.php" class="w-full sm:w-auto text-center bg-blue-600 text-white px-6 py-3 rounded-xl md:rounded-2xl font-bold text-xs md:text-sm hover:bg-blue-700 shadow-lg shadow-blue-100 transition-all">+ Tambah Admin</a>
        </div>

        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-left min-w-[600px]">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-6 md:px-8 py-4 text-[9px] md:text-[11px] font-black text-slate-400 uppercase tracking-widest">Identitas</th>
                        <th class="px-6 md:px-8 py-4 text-[9px] md:text-[11px] font-black text-slate-400 uppercase tracking-widest">NIK</th>
                        <th class="px-6 md:px-8 py-4 text-[9px] md:text-[11px] font-black text-slate-400 uppercase tracking-widest">Role</th>
                        <th class="px-6 md:px-8 py-4 text-[9px] md:text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($users_array as $u) : ?>
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-6 md:px-8 py-4 md:py-6">
                            <div class="font-bold text-slate-700 text-xs md:text-sm truncate max-w-[150px]"><?= $u['email'] ?></div>
                        </td>
                        <td class="px-6 md:px-8 py-4 md:py-6">
                            <span class="font-mono text-[10px] bg-slate-100 px-2 py-1 rounded text-slate-500 font-bold"><?= $u['nik'] ?></span>
                        </td>
                        <td class="px-6 md:px-8 py-4 md:py-6">
                            <?php $isAdmin = ($u['role'] == 'admin'); ?>
                            <span class="px-2 py-1 md:px-3 md:py-1.5 rounded-lg text-[9px] md:text-[10px] font-black uppercase border <?= $isAdmin ? 'bg-rose-50 text-rose-600 border-rose-100' : 'bg-emerald-50 text-emerald-600 border-emerald-100' ?>">
                                <?= $isAdmin ? 'Admin' : 'User' ?>
                            </span>
                        </td>
                        <td class="px-6 md:px-8 py-4 md:py-6 text-center">
                            <div class="flex justify-center gap-3">
                                <a href="ubah_role.php?id=<?= $u['id'] ?>" class="p-2 bg-amber-50 rounded-lg text-sm hover:scale-110 transition-transform" title="Ubah Role">✏️</a>
                                <a href="hapus_user.php?id=<?= $u['id'] ?>" onclick="return confirm('Hapus user?')" class="p-2 bg-rose-50 rounded-lg text-sm hover:scale-110 transition-transform" title="Hapus User">🗑️</a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="md:hidden text-center py-3 bg-slate-50 text-[9px] font-bold text-slate-400 uppercase tracking-tighter">
        </div>
    </div>
</div>
</body>
</html>