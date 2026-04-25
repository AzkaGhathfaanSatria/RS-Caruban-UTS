<?php
session_set_cookie_params(0, '/');
session_start();
require_once 'koneksi.php';

// Pastikan variabel session ada sebelum dicek
$is_login = $_SESSION['login'] ?? false;
$role     = isset($_SESSION['role']) ? strtolower(trim($_SESSION['role'])) : '';

if (!$is_login || $role !== 'admin') {
    header("Location: /index.html");
    exit;
}

// Query Statistik
$total_user       = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM user"));
$total_admin      = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM user WHERE LOWER(TRIM(role))='admin'"));
$total_user_biasa = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM user WHERE LOWER(TRIM(role))='user'"));
$data_user        = mysqli_query($koneksi, "SELECT * FROM user ORDER BY role ASC");
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
            <h1 class="text-2xl md:text-3xl font-black tracking-tight text-slate-900 uppercase">Admin Center</h1>
            <p class="text-slate-500 font-medium mt-1 flex items-center gap-2 text-sm uppercase tracking-tighter">
                <span class="inline-block w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                Node: Vercel Production Server
            </p>
        </div>

        <div class="flex items-center gap-3">
            <div class="hidden md:block text-right mr-2">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest leading-none">Administrator</p>
                <p class="text-xs font-bold text-blue-600"><?php echo htmlspecialchars($_SESSION['email']); ?></p>
            </div>
            <a href="/api/logout.php" class="bg-red-50 text-red-600 px-5 py-2.5 rounded-2xl border border-red-100 hover:bg-red-600 hover:text-white transition-all font-black text-[10px] uppercase tracking-widest shadow-sm">
                Logout
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">
        <div class="bg-white border border-slate-200 rounded-[2.5rem] p-8 shadow-sm">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Personil</p>
            <h3 class="text-4xl font-black text-slate-900 mt-2"><?php echo $total_user; ?></h3>
        </div>
        <div class="bg-white border border-slate-200 rounded-[2.5rem] p-8 shadow-sm">
            <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest">User Biasa</p>
            <h3 class="text-4xl font-black text-slate-900 mt-2"><?php echo $total_user_biasa; ?></h3>
        </div>
        <div class="bg-white border border-slate-200 rounded-[2.5rem] p-8 shadow-sm">
            <p class="text-[10px] font-black text-rose-500 uppercase tracking-widest">Administrator</p>
            <h3 class="text-4xl font-black text-slate-900 mt-2"><?php echo $total_admin; ?></h3>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-[3rem] shadow-sm overflow-hidden mb-12">
        <div class="p-8 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-50/30">
            <div>
                <h2 class="text-xl font-black text-slate-800 tracking-tighter uppercase">Database Master</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Manajemen Hak Akses Akun Terdaftar</p>
            </div>
            <a href="/api/tambah_admin.php" class="bg-blue-600 text-white px-8 py-3 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-blue-700 shadow-xl shadow-blue-100 transition-all active:scale-95">
                + Tambah Admin
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white">
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Email User</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Akses</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php while ($u = mysqli_fetch_assoc($data_user)) { 
                        $u_role = strtolower(trim($u['role']));
                    ?>
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-6">
                            <div class="font-bold text-slate-700 text-sm"><?php echo htmlspecialchars($u['email']); ?></div>
                            <div class="text-[10px] font-mono text-slate-400 mt-0.5 tracking-tighter">NIK: <?php echo htmlspecialchars($u['nik']); ?></div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <?php if ($u_role == 'admin') { ?>
                                <span class="bg-rose-50 text-rose-600 px-4 py-1.5 rounded-xl text-[9px] font-black uppercase border border-rose-100 tracking-tighter">Administrator</span>
                            <?php } else { ?>
                                <span class="bg-blue-50 text-blue-600 px-4 py-1.5 rounded-xl text-[9px] font-black uppercase border border-blue-100 tracking-tighter">User Biasa</span>
                            <?php } ?>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <div class="flex items-center justify-center gap-4">
                                <a href="/api/ubah_role.php?id=<?php echo $u['id']; ?>" class="bg-amber-50 text-amber-600 p-2 rounded-lg hover:bg-amber-100 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <a href="/api/hapus_user.php?id=<?php echo $u['id']; ?>" onclick="return confirm('Hapus user ini?')" class="bg-red-50 text-red-600 p-2 rounded-lg hover:bg-red-100 transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<footer class="py-10 text-center border-t border-slate-100">
    <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.4em]">Internal System • RS Caruban • 2026</p>
</footer>

</body>
</html>
<?php
// Tutup output buffering
ob_end_flush();
?>