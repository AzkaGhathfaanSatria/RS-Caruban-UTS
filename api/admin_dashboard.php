<?php
ob_start();
session_set_cookie_params(0, '/');
session_start();
session_write_close(); 
session_start(); // Trik refresh session di cloud

require_once 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
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
</head>
<body class="bg-slate-50 p-8">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-black">ADMIN CENTER</h1>
            <a href="logout.php" class="text-red-500 font-bold text-sm">LOGOUT</a>
        </div>
        <p class="mb-4 text-slate-500">Halo, <b><?php echo $_SESSION['email']; ?></b></p>
        
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-xs uppercase text-slate-400 border-b">
                    <th class="py-3">Email</th>
                    <th class="py-3">Role</th>
                </tr>
            </thead>
            <tbody>
                <?php while($u = mysqli_fetch_assoc($data_user)): ?>
                <tr class="border-b">
                    <td class="py-3 text-sm"><?php echo $u['email']; ?></td>
                    <td class="py-3"><span class="px-3 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-600 uppercase"><?php echo $u['role']; ?></span></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<?php ob_end_flush(); ?>