<?php
session_set_cookie_params(0, '/');
session_start();
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    $target = ($_SESSION['role'] === 'admin') ? 'api/admin_dashboard' : 'api/dashboard';
    header("Location: $target");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | RS Caruban</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen flex flex-col antialiased">
<div class="flex justify-center items-center flex-grow p-6">
    <div class="bg-white p-8 md:p-12 rounded-[3rem] shadow-2xl w-full max-w-md border border-slate-100">
        <div class="text-center mb-10">
            <img src="RS Caruban.png" class="w-16 h-16 mx-auto mb-6 object-contain" alt="Logo">
            <h1 class="text-3xl font-black text-slate-800">Masuk Sistem</h1>
        </div>
        <?php if(isset($_GET['error'])): ?>
            <div class="bg-red-50 text-red-600 p-3 rounded-2xl text-[10px] font-black text-center mb-6 uppercase">Login Gagal! Data tidak cocok.</div>
        <?php endif; ?>
        <form method="POST" action="api/proses_login" class="space-y-5">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase ml-1">Email</label>
                <input type="email" name="email" required class="w-full bg-slate-50 p-4 rounded-2xl border border-slate-100 focus:bg-white outline-none">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase ml-1">NIK</label>
                <input type="text" name="nik" required class="w-full bg-slate-50 p-4 rounded-2xl border border-slate-100 focus:bg-white outline-none">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase ml-1">Password</label>
                <input type="password" name="password" required class="w-full bg-slate-50 p-4 rounded-2xl border border-slate-100 focus:bg-white outline-none">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white p-4 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-blue-700 transition-all">Masuk Sekarang</button>
        </form>
    </div>
</div>
</body>
</html>