<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$total_user = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user"));
$total_admin = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user WHERE role='admin'"));
$total_user_biasa = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user WHERE role='user'"));

$data_user = mysqli_query($conn, "SELECT * FROM user");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Management System</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<body class="bg-[#fcfcfd] text-slate-900 min-h-screen antialiased">

<div class="max-w-7xl mx-auto p-4 md:p-8">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-10">
        <div>
            <h1 class="text-2xl md:text-3xl font-black tracking-tight text-slate-900">Admin Control Center</h1>
            <p class="text-slate-500 font-medium mt-1 flex items-center gap-2">
                <span class="inline-block w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                Sistem aktif: Kelola data & hak akses user
            </p>
        </div>

        <div class="flex items-center gap-3">
            <div class="hidden md:block text-right mr-2">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest leading-none">Logged in as</p>
                <p class="text-sm font-bold text-slate-700"><?php echo $_SESSION['email'] ?? 'Administrator'; ?></p>
            </div>
            <a href="logout.php" class="flex items-center gap-2 bg-white border border-slate-200 text-slate-600 px-5 py-2.5 rounded-2xl hover:bg-red-50 hover:text-red-600 hover:border-red-100 transition-all duration-300 font-bold text-sm shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7" />
                </svg>
                Logout
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        <div class="bg-white border border-slate-200 rounded-[2rem] p-7 shadow-sm relative overflow-hidden group">
            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-blue-50 rounded-full group-hover:scale-110 transition-transform duration-500"></div>
            <div class="relative">
                <div class="h-12 w-12 bg-blue-600 rounded-2xl flex items-center justify-center text-white mb-5 shadow-lg shadow-blue-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor font-bold">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Total User</p>
                <h3 class="text-4xl font-black text-slate-900 mt-1"><?php echo $total_user; ?></h3>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-[2rem] p-7 shadow-sm relative overflow-hidden group">
            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-emerald-50 rounded-full group-hover:scale-110 transition-transform duration-500"></div>
            <div class="relative">
                <div class="h-12 w-12 bg-emerald-500 rounded-2xl flex items-center justify-center text-white mb-5 shadow-lg shadow-emerald-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">User Biasa</p>
                <h3 class="text-4xl font-black text-slate-900 mt-1"><?php echo $total_user_biasa; ?></h3>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-[2rem] p-7 shadow-sm relative overflow-hidden group sm:col-span-2 lg:col-span-1">
            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-rose-50 rounded-full group-hover:scale-110 transition-transform duration-500"></div>
            <div class="relative">
                <div class="h-12 w-12 bg-rose-500 rounded-2xl flex items-center justify-center text-white mb-5 shadow-lg shadow-rose-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04 Pel0 0-4.498 3.398a11.955 11.955 0 01-1.382 4.016c0 6.627 5.373 12 12 12s12-5.373 12-12a11.954 11.954 0 01-1.382-4.016z" />
                    </svg>
                </div>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Admin</p>
                <h3 class="text-4xl font-black text-slate-900 mt-1"><?php echo $total_admin; ?></h3>
            </div>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-[2.5rem] shadow-sm overflow-hidden">
        <div class="p-8 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-xl font-black text-slate-800 tracking-tight">Database User</h2>
                <p class="text-sm text-slate-500 font-medium">Data seluruh personil yang terdaftar dalam sistem</p>
            </div>

            <a href="tambah_admin.php" class="inline-flex items-center gap-2 bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold text-sm hover:bg-blue-700 shadow-xl shadow-blue-100 active:scale-95 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Admin
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Identitas User</th>
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">NIK / Identitas</th>
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em]">Hak Akses</th>
                        <th class="px-8 py-5 text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php while ($u = mysqli_fetch_assoc($data_user)) { ?>
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 bg-slate-100 rounded-full flex items-center justify-center font-bold text-slate-500 text-xs">
                                    <?php echo strtoupper(substr($u['email'], 0, 2)); ?>
                                </div>
                                <span class="font-bold text-slate-700"><?php echo $u['email']; ?></span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="font-mono text-xs font-semibold text-slate-500 bg-slate-100 px-2 py-1 rounded">
                                <?php echo $u['nik']; ?>
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            <?php if ($u['role'] == 'admin') { ?>
                                <span class="inline-flex items-center gap-1.5 bg-rose-50 text-rose-600 px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider border border-rose-100">
                                    <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span>
                                    Administrator
                                </span>
                            <?php } else { ?>
                                <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider border border-emerald-100">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                                    Reguler User
                                </span>
                            <?php } ?>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="api/ubah_role.php?id=<?php echo $u['id']; ?>" class="p-2 text-amber-500 hover:bg-amber-50 rounded-xl transition-colors title="Ubah Role">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <a href="api/hapus_user.php?id=<?php echo $u['id']; ?>"
                                   onclick="return confirm('Hapus user ini secara permanen?')" 
                                   class="p-2 text-rose-500 hover:bg-rose-50 rounded-xl transition-colors" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
        <div class="p-6 bg-slate-50/50 border-t border-slate-100">
            <p class="text-xs text-center text-slate-400 font-medium italic">Data ini bersifat rahasia, gunakan hak akses admin dengan bijak.</p>
        </div>
    </div>
</div>

</body>
</html>