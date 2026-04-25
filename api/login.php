<?php
// Set pengaturan session agar sinkron dengan folder /api
session_set_cookie_params(0, '/');
session_start();

// Jika user sudah terlanjur login, langsung lempar ke dashboard
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    $target = ($_SESSION['role'] === 'admin') ? 'api/admin_dashboard.php' : 'api/dashboard.php';
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
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-medical {
            background-color: #f8fafc;
            background-image: radial-gradient(#3b82f6 0.5px, transparent 0.5px);
            background-size: 30px 30px;
        }
    </style>
</head>
<body class="bg-medical min-h-screen flex flex-col antialiased">

<div class="flex justify-center items-center flex-grow p-6">
    <div class="bg-white/90 backdrop-blur-xl border border-slate-100 p-8 md:p-12 rounded-[3rem] shadow-2xl shadow-blue-900/10 w-full max-w-md">

        <div class="text-center mb-10">
            <div class="inline-flex p-4 bg-blue-50 rounded-3xl mb-6 shadow-inner">
                <img src="RS Caruban.png" class="w-16 h-16 object-contain" alt="Logo">
            </div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Masuk Sistem</h1>
            <p class="text-slate-500 font-medium mt-2">Gunakan akun RS Caruban Anda</p>
        </div>

        <?php if(isset($_GET['error'])): ?>
            <div class="bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest text-center mb-6">
                Login Gagal! Periksa kembali data Anda.
            </div>
        <?php endif; ?>

        <form method="POST" action="api/proses_login.php" class="space-y-5">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Email</label>
                <input type="email" name="email" required placeholder="nama@email.com"
                class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all outline-none font-medium text-slate-700">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">NIK</label>
                <input type="text" name="nik" required placeholder="16 Digit NIK"
                class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all outline-none font-medium text-slate-700 font-mono">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Password</label>
                <input type="password" name="password" required placeholder="••••••••"
                class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all outline-none font-medium text-slate-700">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white p-4 mt-2 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-blue-700 shadow-xl shadow-blue-200 active:scale-95 transition-all">
                Masuk Sekarang
            </button>
        </form>

        <div class="mt-10 pt-6 border-t border-slate-50 text-center">
            <p class="text-sm font-medium text-slate-500">
                Belum punya akun? 
                <a href="register.php" class="text-blue-600 font-bold hover:underline decoration-2">Daftar</a>
            </p>
        </div>

    </div>
</div>

<footer class="py-8 text-center bg-white/50 border-t border-slate-100">
    <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest">© 2026 RS CARUBAN</p>
</footer>

</body>
</html>