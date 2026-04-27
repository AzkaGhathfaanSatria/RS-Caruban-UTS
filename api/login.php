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

        <div id="notif" class="<?php echo isset($_SESSION['error']) ? '' : 'hidden'; ?> text-center font-bold text-[10px] uppercase tracking-widest p-4 rounded-2xl mb-6 border transition-all <?php echo isset($_SESSION['error']) ? 'bg-red-50 text-red-600 border-red-100' : ''; ?>">
            <?php 
                if(isset($_SESSION['error'])) { 
                    echo $_SESSION['error']; 
                    unset($_SESSION['error']); 
                } 
            ?>
        </div>

        <form method="POST" action="proses_login.php" onsubmit="return validasiLogin()" class="space-y-4 md:space-y-5">
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Email Registrasi</label>
                <input type="email" name="email" id="email" required placeholder="nama@email.com" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-xl md:rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 transition-all outline-none font-medium text-sm text-slate-700">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">NIK (16 Digit)</label>
                <input type="text" name="nik" id="nik" required placeholder="Sesuai KTP" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-xl md:rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 transition-all outline-none font-mono text-sm text-slate-700">
            </div>
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Kata Sandi</label>
                <input type="password" name="password" id="password" required placeholder="••••••••" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-xl md:rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 transition-all outline-none font-medium text-sm text-slate-700">
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
function showNotif(pesan, tipe) {
    let notif = document.getElementById("notif");
    notif.className = "text-center font-bold text-[10px] uppercase tracking-widest p-4 rounded-2xl mb-6 border transition-all " + 
                     (tipe === "error" ? "bg-red-50 text-red-600 border-red-100" : "bg-blue-50 text-blue-600 border-blue-100");
    notif.innerText = pesan;
    notif.classList.remove("hidden");
}

function validasiLogin() {
    let nik = document.getElementById("nik").value;
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;

    if (!email.includes("@")) {
        showNotif("Format email tidak valid!", "error");
        return false;
    }
    if (nik.length !== 16 || isNaN(nik)) {
        showNotif("NIK harus 16 digit angka!", "error");
        return false;
    }
    if (password.length < 8) {
        showNotif("Password minimal 8 karakter!", "error");
        return false;
    }
    return true;
}
</script>
</body>
</html>