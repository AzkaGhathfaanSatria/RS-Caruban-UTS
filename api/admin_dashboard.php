<?php
ob_start();
session_set_cookie_params(0, '/');
session_start();
require_once 'koneksi.php';

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
                <a href="logout.php" class="bg-red-50 text-red-600 px-5 py-2.5 rounded-2xl border border-red-100 hover:bg-red-600 hover:text-white transition-all font-black text-[10px] uppercase tracking-widest shadow-sm">Logout</a>
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
                <h2 class="text-xl font-black text-slate-800 tracking-tighter uppercase">Database Master</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-white text-[10px] font-black text-slate-400 uppercase tracking-widest">
                            <th class="px-8 py-5">Email User</th>
                            <th class="px-8 py-5 text-center">Akses</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php while ($u = mysqli_fetch_assoc($data_user)): 
                            $u_role = strtolower(trim($u['role'])); ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-8 py-6 font-bold text-slate-700 text-sm"><?php echo htmlspecialchars($u['email']); ?></td>
                            <td class="px-8 py-6 text-center">
                                <span class="<?php echo ($u_role == 'admin') ? 'bg-rose-50 text-rose-600' : 'bg-blue-50 text-blue-600'; ?> px-4 py-1.5 rounded-xl text-[9px] font-black uppercase border tracking-tighter">
                                    <?php echo $u_role; ?>
                                </span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
<?php ob_end_flush(); ?>