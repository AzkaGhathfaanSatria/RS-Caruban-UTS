<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | RS Caruban</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-medical {
            background-color: #f0f9ff;
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
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Selamat Datang</h1>
            <p class="text-slate-500 font-medium mt-2">Masuk untuk mengakses layanan RS Caruban</p>
        </div>

        <div id="error-box" class="hidden bg-red-50 border border-red-100 text-red-600 px-4 py-3 rounded-2xl text-xs font-bold uppercase tracking-widest text-center mb-6 animate-pulse">
            Login Gagal! Cek kembali data Anda.
        </div>

        <form method="POST" action="/api/proses_login.php" class="space-y-5">
            
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Email Registrasi</label>
                <div class="relative">
                    <input type="email" name="email" required placeholder="nama@email.com"
                    class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all outline-none font-medium text-slate-700">
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">NIK (16 Digit)</label>
                <input type="text" name="nik" required placeholder="Sesuai KTP"
                class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all outline-none font-medium text-slate-700 font-mono text-sm">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Kata Sandi</label>
                <input type="password" name="password" required placeholder="••••••••"
                class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 focus:border-blue-400 transition-all outline-none font-medium text-slate-700">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white p-4 mt-2 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-blue-700 shadow-xl shadow-blue-200 active:scale-95 transition-all">
                Masuk ke Sistem
            </button>

        </form>

        <div class="mt-10 pt-6 border-t border-slate-50 text-center">
            <p class="text-sm font-medium text-slate-500">
                Belum memiliki akun? 
                <a href="/api/register.php" class="text-blue-600 font-bold hover:text-blue-700 underline underline-offset-4 decoration-2">
                    Daftar di sini
                </a>
            </p>
        </div>

    </div>
</div>

<footer class="py-8 text-center bg-white/50 border-t border-slate-100">
    <div class="max-w-md mx-auto px-6">
        <p class="text-slate-400 text-[10px] font-black uppercase tracking-[0.2em] mb-2">Pusat Bantuan RS Caruban</p>
        <p class="text-slate-500 text-xs font-medium italic">
            📍 Caruban, Madiun • 📞 021-912007 • 💬 0812-2345-6789
        </p>
        <p class="text-slate-300 text-[10px] mt-4 font-bold tracking-tighter">© 2026 RS CARUBAN. ALL RIGHTS RESERVED.</p>
    </div>
</footer>

<script>
    // Script sederhana untuk nangkep error dari URL (misal: ?error=1)
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('error')) {
        document.getElementById('error-box').classList.remove('hidden');
    }
</script>

</body>
</html>