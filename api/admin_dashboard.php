<?php
ob_start();
session_set_cookie_params(0, '/');
session_start();
session_write_close(); 
session_start(); 

require_once 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: /login.php");
    exit;
}

$data_user = mysqli_query($koneksi, "SELECT * FROM user ORDER BY role ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 p-8">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
        <div class="flex justify-between items-center mb-6 border-b pb-6">
            <h1 class="text-2xl font-black uppercase tracking-tighter">Admin Center</h1>
            <a href="logout.php" class="bg-red-50 text-red-600 px-4 py-2 rounded-xl font-bold text-xs">LOGOUT</a>
        </div>
        <p class="mb-6 text-slate-500 text-sm">Masuk sebagai: <b class="text-blue-600"><?php echo htmlspecialchars($_SESSION['email']); ?></b></p>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[10px] uppercase text-slate-400 font-black tracking-widest border-b">
                        <th class="py-4 px-2">Email Pengguna</th>
                        <th class="py-4 px-2 text-center">Status Akses</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($u = mysqli_fetch_assoc($data_user)): ?>
                    <tr class="border-b last:border-0 hover:bg-slate-50">
                        <td class="py-4 px-2 text-sm font-semibold"><?php echo htmlspecialchars($u['email']); ?></td>
                        <td class="py-4 px-2 text-center">
                            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase border <?php echo ($u['role'] == 'admin') ? 'bg-rose-50 text-rose-600 border-rose-100' : 'bg-blue-50 text-blue-600 border-blue-100'; ?>">
                                <?php echo htmlspecialchars($u['role']); ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
<?php ob_end_flush(); ?>