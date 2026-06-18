<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sidu-Apps - Sistem Registrasi Peserta Didik SMK Negeri 1 Kawali</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>

    @vite(['resources/css/app.css','resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-[#f8fafc] text-slate-800 antialiased selection:bg-indigo-500 selection:text-white">

    <header class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold shadow-lg shadow-indigo-600/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </div>
                <div>
                    <h1 class="font-extrabold text-sm tracking-wide text-slate-900 uppercase">Sidu-Apps</h1>
                    <p class="text-[10px] text-slate-400 font-semibold tracking-wider uppercase">SMK Negeri 1 Kawali</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ auth()->user()->role->nama_role == 'siswa' ? route('siswa.dashboard') : route('admin.dashboard') }}" 
                       class="px-5 py-2.5 bg-slate-900 hover:bg-slate-800 text-white text-sm font-semibold rounded-xl transition shadow-sm">
                        Ke Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition shadow-lg shadow-indigo-600/15">
                        Login Akun
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <section class="relative overflow-hidden py-20 lg:py-32">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[400px] bg-gradient-to-b from-indigo-50/50 to-transparent rounded-full blur-3xl -z-10"></div>

        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-semibold tracking-wide">
                    <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                    Tahun Ajaran 2026/2027 Telah Dibuka
                </div>
                <h2 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.15]">
                    Sistem Registrasi <br class="hidden sm:block">
                    <span class="text-indigo-600">Peserta Didik Baru</span> Mandiri.
                </h2>
                <p class="text-slate-500 text-base sm:text-lg max-w-2xl mx-auto lg:mx-0 font-medium leading-relaxed">
                    Selamat datang di Sidu-Apps SMK Negeri 1 Kawali. Kemudahan melakukan pendaftaran, perbaikan data biodata, hingga pemantauan status berkas secara realtime dalam satu platform terintegrasi.
                </p>
                
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-4">
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl transition text-center shadow-xl shadow-indigo-600/20 group flex items-center justify-center gap-2">
                        <span>Mulai Daftar Sekarang</span>
                        <svg class="w-4 h-4 transition group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                    <a href="#alur" class="w-full sm:w-auto px-8 py-4 bg-white hover:bg-slate-50 text-slate-700 border border-slate-200/80 font-bold rounded-2xl transition text-center shadow-sm">
                        Lihat Alur Pendaftaran
                    </a>
                </div>
            </div>

            <div class="lg:col-span-5 hidden lg:block">
                <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-xl relative">
                    <div class="absolute -top-6 -left-6 bg-emerald-500 text-white p-4 rounded-2xl shadow-lg shadow-emerald-500/20 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-white/20 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div>
                            <div class="text-[10px] uppercase tracking-wider font-bold opacity-80">Akun Siswa</div>
                            <div class="text-xs font-bold">Otomatis Dibuat!</div>
                        </div>
                    </div>

                    <div class="space-y-4 bg-slate-900 text-slate-400 p-6 rounded-2xl border border-slate-800">
                        <div class="flex items-center gap-2 pb-3 border-b border-slate-800">
                            <div class="w-3 h-3 rounded-full bg-rose-500"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                            <span class="text-[11px] text-slate-600 font-mono ml-2">smkn1kawali-auth.sys</span>
                        </div>
                        <div class="space-y-3 font-mono text-xs">
                            <p class="text-indigo-400">// Kredensial Login default Siswa</p>
                            <p><span class="text-purple-400">username :</span> <span class="text-emerald-400">"NOMOR_NISN_ANDA"</span></p>
                            <p><span class="text-purple-400">password :</span> <span class="text-emerald-400">"smkn1kawali"</span></p>
                        </div>
                    </div>

                    <div class="mt-6 p-4 rounded-xl bg-slate-50 border border-slate-100 flex justify-between items-center text-xs">
                        <span class="text-slate-400 font-medium">Butuh bantuan teknis?</span>
                        <span class="font-bold text-indigo-600 hover:underline cursor-pointer">Hubungi Panitia</span>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section id="alur" class="py-20 bg-white border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-6">
            
            <div class="text-center max-w-2xl mx-auto space-y-3 mb-16">
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">3 Langkah Mudah Pendaftaran</h3>
                <p class="text-slate-400 text-sm font-medium">Proses transparan dan efisien tanpa perlu antre lama di sekolah.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="space-y-4 p-6 rounded-2xl hover:bg-slate-50 transition duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 text-indigo-600 font-extrabold flex items-center justify-center text-lg shadow-sm">
                        1
                    </div>
                    <h4 class="font-bold text-lg text-slate-900">Input / Buat Akun</h4>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">
                        Data Anda diinputkan oleh operator sekolah atau melakukan registrasi awal. Sistem akan langsung membuatkan akun personal menggunakan nomor **NISN** Anda.
                    </p>
                </div>

                <div class="space-y-4 p-6 rounded-2xl hover:bg-slate-50 transition duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 font-extrabold flex items-center justify-center text-lg shadow-sm">
                        2
                    </div>
                    <h4 class="font-bold text-lg text-slate-900">Verifikasi & Edit Mandiri</h4>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">
                        Masuk menggunakan akun Anda. Periksa kembali rekam biodata Anda, dan ubah secara mandiri jika didapati kesalahan penulisan oleh operator sebelum data dikunci.
                    </p>
                </div>

                <div class="space-y-4 p-6 rounded-2xl hover:bg-slate-50 transition duration-300">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 text-amber-600 font-extrabold flex items-center justify-center text-lg shadow-sm">
                        3
                    </div>
                    <h4 class="font-bold text-lg text-slate-900">Pantau Status Kelulusan</h4>
                    <p class="text-slate-500 text-sm leading-relaxed font-medium">
                        Pantau berkala halaman dashboard siswa Anda untuk melihat pengumuman validasi berkas fisik serta status akhir penempatan jalur pendaftaran sekolah.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <footer class="bg-[#0f172a] text-slate-400 py-12">
        <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-6 border-b border-slate-800 pb-8">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </div>
                <span class="text-sm font-bold text-white uppercase tracking-wider">Sidu-Apps</span>
            </div>
            <p class="text-xs font-medium text-slate-500 text-center sm:text-right">
                &copy; 2026 SMK Negeri 1 Kawali. Seluruh hak cipta dilindungi undang-undang.
            </p>
        </div>
    </footer>

</body>

</html>