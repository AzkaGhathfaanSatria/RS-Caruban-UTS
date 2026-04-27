<?php 
session_start(); 

if (isset($_SESSION['login']) || (isset($_COOKIE['user_login']) && $_COOKIE['user_login'] === 'true')) {
    $role = $_SESSION['role'] ?? $_COOKIE['user_role'] ?? '';
    header("Location: " . ($role === 'admin' ? "admin_dashboard.php" : "dashboard.php"));
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login | RS Caruban</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: radial-gradient(#3b82f615 0.5px, #f0f9ff 0.5px) 0 0/30px 30px; }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased">

<div class="flex justify-center items-center flex-grow p-4 md:p-6">
    <div class="bg-white/95 backdrop-blur-xl border border-slate-100 p-8 md:p-12 rounded-[2.5rem] md:rounded-[3rem] shadow-2xl shadow-blue-900/10 w-full max-w-md">
        
        <div class="text-center mb-8 md:mb-10">
            <a href="../index.html" class="inline-flex p-3 md:p-4 bg-blue-50 rounded-2xl md:rounded-3xl mb-4 md:mb-6 shadow-inner hover:scale-105 transition-transform">
                <img src="../RSCaruban.png" class="w-12 h-12 md:w-16 md:h-16 object-contain" alt="Logo">
            </a>
            <h1 class="text-2xl md:text-3xl font-black text-slate-800 tracking-tight">Selamat Datang</h1>
            <p class="text-slate-500 font-medium mt-2 text-sm md:text-base">Masuk untuk mengakses layanan</p>
        </div>

        <?php if(isset($_SESSION['error'])): ?>
            <div class="bg-red-50 border border-red-100 text-red-600 px-4 py-4 rounded-full text-[10px] font-bold uppercase tracking-widest text-center mb-6 shadow-sm">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="proses_login.php" class="space-y-4 md:space-y-5">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Email Registrasi</label>
                <input type="email" name="email" required placeholder="nama@email.com" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-xl md:rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 transition-all outline-none font-medium text-sm text-slate-700">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">NIK (16 Digit)</label>
                <input type="text" name="nik" required placeholder="Sesuai KTP" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-xl md:rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 transition-all outline-none font-mono text-sm text-slate-700">
            </div>
            
            <div class="relative">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Kata Sandi</label>
                <div class="relative">
                    <input type="password" name="password" id="password" required placeholder="••••••••" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-xl md:rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 transition-all outline-none font-medium text-sm text-slate-700 pr-12">
                    
                    <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" id="eye-icon" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white p-5 mt-2 rounded-[2rem] font-black text-xs uppercase tracking-widest hover:bg-blue-700 shadow-xl shadow-blue-100 active:scale-95 transition-all">
                Masuk ke Sistem
            </button>
        </form>

        <div class="mt-8 md:mt-10 pt-6 border-t border-slate-50 text-center">
            <p class="text-xs md:text-sm font-medium text-slate-500">Belum punya akun? <a href="register.php" class="text-blue-600 font-bold hover:underline">Daftar Sekarang</a></p>
        </div>
    </div>
</div>

<footer class="py-6 text-center">
    <p class="text-slate-400 text-[9px] md:text-[10px] font-black uppercase tracking-[0.2em]">© 2026 RS CARUBAN</p>
</footer>

<script>
function togglePassword() {
    let pw = document.getElementById("password");
    let icon = document.getElementById("eye-icon");
    if (pw.type === "password") {
        pw.type = "text";
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 1.253 0 2.426.235 3.525.657m-8.69 8.69a3 3 0 004.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />';
    } else {
        pw.type = "password";
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7" />';
    }
}
</script>
</body>
</html>