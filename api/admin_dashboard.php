<?php
session_start();
include 'koneksi.php'; // Karena admin_dashboard.php dan koneksi.php sama-sama di folder api

// PROTEKSI SESSION
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: /index.html"); // Balik ke halaman login utama di root
    exit;
}

$total_user = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM user"));
$total_admin = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM user WHERE role='admin'"));
$total_user_biasa = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM user WHERE role='user'"));

$data_user = mysqli_query($koneksi, "SELECT * FROM user");
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
                Sistem aktif: Kelola data & hak akses user
            </p>
        </div>

        <div class="flex items-center gap-3">
            <div class="hidden md:block text-right mr-2">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Logged in as</p>
                <p class="text-sm font-bold text-slate-700"><?php echo htmlspecialchars($_SESSION['email'] ?? 'Administrator'); ?></p>
            </div>
            <a href="/api/logout.php" class="flex items-center gap-2 bg-white border border-slate-200 text-slate-600 px-5 py-2.5 rounded-2xl hover:bg-red-50 hover:text-red-600 hover:border-red-100 transition-all font-bold text-sm shadow-sm">
                Logout
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        <div class="bg-white border border-slate-200 rounded-[2rem] p-7 shadow-sm">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total User</p>
            <h3 class="text-4xl font-black text-slate-900 mt-1"><?php echo $total_user; ?></h3>
        </div>
        <div class="bg-white border border-slate-200 rounded-[2rem] p-7 shadow-sm">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">User Biasa</p>
            <h3 class="text-4xl font-black text-slate-900 mt-1"><?php echo $total_user_biasa; ?></h3>
        </div>
        <div class="bg-white border border-slate-200 rounded-[2rem] p-7 shadow-sm">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Admin</p>
            <h3 class="text-4xl font-black text-slate-900 mt-1"><?php echo $total_admin; ?></h3>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-[2.5rem] shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-xl font-black text-slate-800 tracking-tight uppercase">Database User</h2>
                <p class="text-sm text-slate-500 font-medium">Data seluruh personil yang terdaftar</p>
            </div>

            <a href="/api/tambah_admin.php" class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold text-sm hover:bg-blue-700 shadow-xl shadow-blue-100 transition-all">
                Tambah Admin
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-widest">Identitas User</th>
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-widest">NIK</th>
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-widest">Hak Akses</th>
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-widest text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php while ($u = mysqli_fetch_assoc($data_user)) { ?>
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-8 py-6">
                            <span class="font-bold text-slate-700"><?php echo htmlspecialchars($u['email']); ?></span>
                        </td>
                        <td class="px-8 py-6">
                            <span class="font-mono text-xs font-semibold text-slate-500 bg-slate-100 px-2 py-1 rounded">
                                <?php echo htmlspecialchars($u['nik']); ?>
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <?php if ($u['role'] == 'admin') { ?>
                                <span class="bg-rose-50 text-rose-600 px-3 py-1.5 rounded-xl text-[10px] font-black uppercase border border-rose-100">Administrator</span>
                            <?php } else { ?>
                                <span class="bg-emerald-50 text-emerald-600 px-3 py-1.5 rounded-xl text-[10px] font-black uppercase border border-emerald-100">User</span>
                            <?php } ?>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <div class="flex items-center justify-center gap-3">
                                <a href="/api/ubah_role.php?id=<?php echo $u['id']; ?>" class="text-amber-500 font-bold text-xs hover:underline">Ubah</a>
                                <a href="/api/hapus_user.php?id=<?php echo $u['id']; ?>" 
                                   onclick="return confirm('Hapus user ini?')" 
                                   class="text-rose-500 font-bold text-xs hover:underline">Hapus</a>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>