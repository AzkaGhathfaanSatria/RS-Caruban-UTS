<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Staf Baru | RS Caruban</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>

<body class="bg-slate-50 min-h-screen flex flex-col justify-center items-center p-6 antialiased">

<div class="bg-white p-10 md:p-14 rounded-[3.5rem] shadow-2xl shadow-slate-200 w-full max-w-2xl border border-white">
    <div class="text-center mb-10">
        <h1 class="text-3xl font-black text-slate-900 tracking-tighter">Registrasi Internal Staf</h1>
        <p class="text-slate-400 font-medium mt-2 text-sm">Lengkapi data di bawah untuk membuat akses Administrator baru.</p>
    </div>

    <form method="POST" action="proses_tambah_admin.php" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="md:col-span-2">
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
            <input type="text" name="nama" required placeholder="Nama Lengkap Staf" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 outline-none font-bold text-slate-700">
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">NIK</label>
            <input type="text" name="nik" required placeholder="16 Digit NIK" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 outline-none font-bold text-slate-700">
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">No. WhatsApp</label>
            <input type="text" name="no_hp" required placeholder="0812xxxx" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 outline-none font-bold text-slate-700">
        </div>

        <div class="md:col-span-2">
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Alamat Tinggal</label>
            <textarea name="alamat" required placeholder="Alamat lengkap staf..." rows="2" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 outline-none font-bold text-slate-700"></textarea>
        </div>

        <div class="md:col-span-2">
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Email</label>
            <input type="email" name="email" required placeholder="nama@email.com" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 outline-none font-bold text-slate-700">
        </div>

        <div class="md:col-span-2">
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Password</label>
            <input type="password" name="password" required placeholder="Buat password aman" class="w-full bg-slate-50 border border-slate-100 p-4 rounded-2xl focus:bg-white focus:ring-4 focus:ring-blue-100 outline-none font-bold text-slate-700">
        </div>

        <button class="md:col-span-2 w-full bg-slate-900 text-white p-5 rounded-3xl font-black text-xs uppercase tracking-widest hover:bg-blue-600 shadow-xl transition-all">
            Daftarkan & Beri Akses Admin
        </button>
    </form>
</div>
</body>
</html>