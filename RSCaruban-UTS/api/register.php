<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | RS Caruban</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-pattern {
            background-color: #f0fdf4;
            background-image: radial-gradient(#22c55e 0.5px, transparent 0.5px);
            background-size: 20px 20px;
            background-opacity: 0.1;
        }
    </style>
</head>

<body class="bg-pattern min-h-screen flex flex-col antialiased">

<div class="flex justify-center items-center flex-grow p-6">

<div class="bg-white/90 backdrop-blur-sm border border-slate-100 p-8 md:p-10 rounded-[2.5rem] shadow-2xl shadow-green-900/5 w-full max-w-lg">

    <div class="text-center mb-8">
        <div class="inline-flex p-3 bg-green-50 rounded-2xl mb-4">
            <img src="RS Caruban.png" class="w-10 h-10 object-contain" alt="Logo">
        </div>
        <h1 class="text-3xl font-black text-slate-800 tracking-tight">Buat Akun</h1>
        <p class="text-slate-500 font-medium mt-2">Daftar untuk akses layanan kesehatan digital</p>
    </div>

    <div id="notif" class="hidden animate-bounce-short text-center font-bold text-xs uppercase tracking-widest p-4 rounded-2xl mb-6 shadow-sm border"></div>

    <form method="POST" action="proses_register.php" onsubmit="return validasi()" class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div class="md:col-span-2">
            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Alamat Email</label>
            <input type="email" name="email" id="email" required placeholder="nama@email.com"
            class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-green-100 focus:border-green-400 transition-all outline-none font-medium text-slate-700">
        </div>

        <div class="md:col-span-2">
            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
            <input type="text" name="nama" required placeholder="Sesuai KTP"
            class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-green-100 focus:border-green-400 transition-all outline-none font-medium text-slate-700">
        </div>

        <div>
            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">NIK</label>
            <input type="text" name="nik" id="nik" required placeholder="16 Digit"
            class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-green-100 focus:border-green-400 transition-all outline-none font-medium text-slate-700">
        </div>

        <div>
            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">No. WhatsApp</label>
            <input type="text" name="no_hp" required placeholder="0812..."
            class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-green-100 focus:border-green-400 transition-all outline-none font-medium text-slate-700">
        </div>

        <div class="md:col-span-2">
            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Alamat Domisili</label>
            <textarea name="alamat" required placeholder="Alamat lengkap saat ini" rows="2"
            class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-green-100 focus:border-green-400 transition-all outline-none font-medium text-slate-700 resize-none"></textarea>
        </div>

        <div class="md:col-span-2 relative">
            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Password</label>
            <input type="password" name="password" id="password" required placeholder="Min. 8 Karakter"
            class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-green-100 focus:border-green-400 transition-all outline-none font-medium text-slate-700">
            
            <button type="button" onclick="togglePassword()" class="absolute right-4 top-10 text-slate-400 hover:text-green-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" id="eye-icon" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </button>
        </div>

        <input type="hidden" name="role" value="user">

        <button class="md:col-span-2 w-full bg-green-600 text-white p-4 mt-4 rounded-2xl font-black text-sm uppercase tracking-widest hover:bg-green-700 shadow-xl shadow-green-200 active:scale-95 transition-all">
            Konfirmasi Pendaftaran
        </button>

    </form>

    <div class="mt-8 pt-6 border-t border-slate-50 text-center">
        <p class="text-sm font-medium text-slate-500">
            Sudah memiliki akun? 
            <a href="login.php" class="text-green-600 font-bold hover:text-green-700 underline underline-offset-4 decoration-2">
                Login di sini
            </a>
        </p>
    </div>

</div>
</div>

<footer class="py-8 text-center">
    <p class="text-slate-400 text-xs font-bold uppercase tracking-[0.2em]">© 2026 RS CARUBAN • MADIUN, JAWA TIMUR</p>
</footer>

<script>
function showNotif(pesan, tipe) {
    let notif = document.getElementById("notif");
    notif.classList.remove("hidden", "bg-red-50", "text-red-600", "border-red-100", "bg-green-50", "text-green-600", "border-green-100");
    
    if(tipe === "error") {
        notif.classList.add("bg-red-50", "text-red-600", "border-red-100");
    } else {
        notif.classList.add("bg-green-50", "text-green-600", "border-green-100");
    }
    
    notif.innerText = pesan;
    notif.classList.remove("hidden");
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function validasi() {
    let nik = document.getElementById("nik").value;
    let password = document.getElementById("password").value;

    if (nik.length !== 16 || isNaN(nik)) {
        showNotif("Format NIK tidak valid (harus 16 angka)!", "error");
        return false;
    }

    if (password.length < 8 || password.length > 16) {
        showNotif("Keamanan password kurang (min. 8, max. 16 karakter)!", "error");
        return false;
    }

    return true;
}

function togglePassword() {
    let pw = document.getElementById("password");
    let icon = document.getElementById("eye-icon");
    if (pw.type === "password") {
        pw.type = "text";
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7 1.274-4.057 5.064-7 9.542-7 1.253 0 2.426.235 3.525.657m-8.69 8.69a3 3 0 004.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />';
    } else {
        pw.type = "password";
        icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
    }
}
</script>

</body>
</html>