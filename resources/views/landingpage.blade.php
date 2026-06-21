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

    <!-- HEADER -->
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

    <!-- HERO SECTION -->
    <section class="relative overflow-hidden py-10 lg:py-15">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1000px] h-[400px] bg-gradient-to-b from-indigo-50/50 to-transparent rounded-full blur-3xl -z-10"></div>

        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-semibold tracking-wide">
                    <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                    Tahun Ajaran 2026/2027 Telah Dibuka
                </div>
                <h2 class="text-3xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.15]">
                    Sistem Daftar Ulang <br class="hidden sm:block">
                    <span class="text-indigo-600">Peserta Didik Baru</span> SMKN 1 Kawali
                </h2>
                <p class="text-slate-500 text-sm sm:text-lg max-w-2xl mx-auto lg:mx-0 font-medium leading-relaxed">
                    Selamat datang di Sidu-Apps SMK Negeri 1 Kawali. Kemudahan melakukan pendaftaran, perbaikan data biodata, hingga pemantauan status berkas secara realtime dalam satu platform terintegrasi.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-4">
                    <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl transition text-center shadow-xl shadow-indigo-600/20 group flex items-center justify-center gap-2">
                        <span>Mulai Daftar Sekarang</span>
                        <svg class="w-4 h-4 transition group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
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
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
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

                </div>
            </div>

        </div>
    </section>

    <!-- ALUR PENDAFTARAN -->
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
                    <h4 class="font-bold text-lg text-slate-900">Penginputan Data</h4>
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

    <!-- TAMBAHAN SECTION 1: KOMPETENSI KEAHLIAN / JURUSAN -->
<!-- TAMBAHAN SECTION 1: KOMPETENSI KEAHLIAN / JURUSAN -->
    <section class="py-20 bg-[#f8fafc]">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto space-y-3 mb-16">
                <span class="text-xs font-bold text-indigo-600 tracking-wider uppercase bg-indigo-50 px-3 py-1 rounded-full">Pilihan Masa Depan</span>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Kompetensi Keahlian</h3>
                <p class="text-slate-500 text-sm font-medium">Pilih program studi unggulan yang dirancang untuk mencetak lulusan siap kerja dan berdaya saing tinggi.</p>
            </div>

            <!-- Menggunakan Grid yang adaptif untuk 7 Jurusan -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-6">
                
                <!-- Jurusan 1: Teknik Otomotif -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-slate-900 mb-1 text-base leading-snug">Teknik Otomotif</h4>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-2">TO (TKR)</p>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">Pendalaman bidang teknik kendaraan, perawatan berkala engine, sasis, pemindah tenaga, dan kelistrikan otomotif.</p>
                    </div>
                </div>

                <!-- Jurusan 2: TJKT -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-slate-900 mb-1 text-base leading-snug">Teknik Jaringan Komputer & Telekomunikasi</h4>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-2">TJKT (TKJ)</p>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">Mempelajari perencanaan infrastruktur jaringan, administrasi server, cyber security, fiber optic, dan perbaikan perangkat telekomunikasi.</p>
                    </div>
                </div>

                <!-- Jurusan 3: PPLG -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-slate-900 mb-1 text-base leading-snug">Pengembangan Perangkat Lunak & Gim</h4>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-2">PPLG (RPL)</p>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">Fokus pada pembuatan aplikasi website, mobile apps, rekayasa basis data,UI/UX, serta pengembangan industri kreatif digital berbasis gim.</p>
                    </div>
                </div>

                <!-- Jurusan 4: DPIB -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-slate-900 mb-1 text-base leading-snug">Desain Pemodelan & Informasi Bangunan</h4>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-2">DPIB</p>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">Mempelajari perencanaan gambar arsitektur kontruksi bangunan, estimasi anggaran biaya (RAB), pemodelan 3D, dan pemanfaatan teknologi BIM.</p>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-6 mt-5">
                <!-- Jurusan 5: MPLB -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2zm5-4h8m-4 0v4m-4 4h8m-8 4h8" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-slate-900 mb-1 text-base leading-snug">Manajemen Perkantoran & Layanan Bisnis</h4>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-2">MPLB</p>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">Pembelajaran tata kelola administrasi modern, korespondensi bisnis, manajemen arsip digital, public relations, dan otomatisasi perkantoran.</p>
                    </div>
                </div>

                <!-- Jurusan 6: AKL -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-slate-900 mb-1 text-base leading-snug">Akuntansi & Keuangan Lembaga</h4>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-2">AKL</p>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">Pembelajaran komprehensif akuntansi keuangan korporasi, pengelolaan instansi lembaga keuangan, analisis pajak, dan spreadsheet bisnis.</p>
                    </div>
                </div>

                <!-- Jurusan 7: Seni Pertunjukan -->
                <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition flex flex-col justify-between sm:col-span-2 lg:col-span-1">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-slate-900 mb-1 text-base leading-snug">Seni Pertunjukan</h4>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-2">SP</p>
                        <p class="text-xs text-slate-500 leading-relaxed font-medium">Wadah kreativitas dalam melestarikan budaya dan mengasah bakat bidang seni musik, seni tari, tata panggung, serta manajemen industri kreatif.</p>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>

    <!-- TAMBAHAN SECTION 2: PERSYARATAN BERKAS / DOKUMEN -->
    <section class="py-20 bg-white border-t border-slate-100">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-5 space-y-4">
                <span class="text-xs font-bold text-indigo-600 tracking-wider uppercase bg-indigo-50 px-3 py-1 rounded-full">Persiapan Daftar Ulang</span>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Kelengkapan Dokumen Fisik</h3>
                <p class="text-slate-500 text-sm leading-relaxed font-medium">
                    Sebelum melakukan validasi di sekolah, harap pastikan Anda telah membawa berkas asli beserta fotokopi yang telah dilegalisir sesuai daftar di samping guna mempercepat proses antrean.
                </p>
                <div class="p-4 rounded-xl bg-amber-50 border border-amber-100 text-amber-800 text-xs flex gap-3">
                    <svg class="w-5 h-5 shrink-0 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span><strong>Penting:</strong> Penyalahgunaan data atau pemalsuan dokumen berkas pendaftaran berakibat pembatalan status hak kelulusan siswa.</span>
                </div>
            </div>

            <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="flex items-start gap-3 p-4 bg-[#f8fafc] rounded-xl border border-slate-100">
                    <div class="p-2 rounded-lg bg-emerald-100 text-emerald-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg></div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900">Kartu Keluarga (KK)</h4>
                        <p class="text-xs text-slate-400 mt-0.5">Asli & Fotokopi (2 Lembar)</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 p-4 bg-[#f8fafc] rounded-xl border border-slate-100">
                    <div class="p-2 rounded-lg bg-emerald-100 text-emerald-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg></div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900">Akta Kelahiran</h4>
                        <p class="text-xs text-slate-400 mt-0.5">Asli & Fotokopi (2 Lembar)</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 p-4 bg-[#f8fafc] rounded-xl border border-slate-100">
                    <div class="p-2 rounded-lg bg-emerald-100 text-emerald-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg></div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900">Ijazah / Surat Keterangan Lulus</h4>
                        <p class="text-xs text-slate-400 mt-0.5">Fotokopi Dilegalisir (2 Lembar)</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 p-4 bg-[#f8fafc] rounded-xl border border-slate-100">
                    <div class="p-2 rounded-lg bg-emerald-100 text-emerald-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg></div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900">Pas Foto Terbaru</h4>
                        <p class="text-xs text-slate-400 mt-0.5">Ukuran 3x4 Background Merah (3 Lembar)</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 p-4 bg-[#f8fafc] rounded-xl border border-slate-100">
                    <div class="p-2 rounded-lg bg-emerald-100 text-emerald-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg></div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900">Bukti Pendaftaran Online</h4>
                        <p class="text-xs text-slate-400 mt-0.5">Dicetak melalui portal PPDB Jabar</p>
                    </div>
                </div>
                <div class="flex items-start gap-3 p-4 bg-[#f8fafc] rounded-xl border border-slate-100">
                    <div class="p-2 rounded-lg bg-emerald-100 text-emerald-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg></div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900">KIP / KKS / PKH</h4>
                        <p class="text-xs text-slate-400 mt-0.5">Fotokopi (Khusus Jalur Afirmasi)</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TAMBAHAN SECTION 3: FAQ (PERTANYAAN UMUM) DENGAN ALPINE.JS ACCORDION -->
    <section class="py-20 bg-[#f8fafc] border-t border-slate-100">
        <div class="max-w-4xl mx-auto px-6">
            <div class="text-center space-y-3 mb-12">
                <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Sering Ditanyakan (FAQ)</h3>
                <p class="text-slate-500 text-sm font-medium">Butuh jawaban cepat? Cek kompilasi solusi pertanyaan seputar Sidu-Apps berikut.</p>
            </div>

            <div x-data="{ active: null }" class="space-y-3">
                <!-- FAQ 1 -->
                <div class="bg-white rounded-xl border border-slate-200/60 overflow-hidden shadow-sm">
                    <button @click="active = (active === 1 ? null : 1)" class="w-full px-6 py-4 flex items-center justify-between font-bold text-left text-sm sm:text-base text-slate-900 bg-white hover:bg-slate-50 transition">
                        <span>Bagaimana cara mendapatkan akun login Sidu-Apps?</span>
                        <svg class="w-5 h-5 text-slate-400 transition transform" :class="active === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="active === 1" x-collapse x-cloak class="px-6 pb-5 pt-1 text-xs sm:text-sm text-slate-500 font-medium leading-relaxed border-t border-slate-50">
                        Akun Anda dibuat secara otomatis oleh admin panitia setelah data awal di-input dari berkas pendaftaran Anda. Username default adalah nomor NISN Anda, dan password awal adalah <code class="bg-slate-100 px-1 py-0.5 rounded font-mono text-indigo-600 font-bold">smkn1kawali</code>.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white rounded-xl border border-slate-200/60 overflow-hidden shadow-sm">
                    <button @click="active = (active === 2 ? null : 2)" class="w-full px-6 py-4 flex items-center justify-between font-bold text-left text-sm sm:text-base text-slate-900 bg-white hover:bg-slate-50 transition">
                        <span>Apakah proses daftar ulang melalui aplikasi ini dipungut biaya?</span>
                        <svg class="w-5 h-5 text-slate-400 transition transform" :class="active === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="active === 2" x-collapse x-cloak class="px-6 pb-5 pt-1 text-xs sm:text-sm text-slate-500 font-medium leading-relaxed border-t border-slate-50">
                        Tidak. Penggunaan sistem Sidu-Apps dan seluruh rangkaian proses administrasi pendaftaran/daftar ulang daring di SMK Negeri 1 Kawali ini sepenuhnya gratis dan tidak dipungut biaya apa pun.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white rounded-xl border border-slate-200/60 overflow-hidden shadow-sm">
                    <button @click="active = (active === 3 ? null : 3)" class="w-full px-6 py-4 flex items-center justify-between font-bold text-left text-sm sm:text-base text-slate-900 bg-white hover:bg-slate-50 transition">
                        <span>Bagaimana jika biodata NISN atau Nama saya salah input?</span>
                        <svg class="w-5 h-5 text-slate-400 transition transform" :class="active === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="active === 3" x-collapse x-cloak class="px-6 pb-5 pt-1 text-xs sm:text-sm text-slate-500 font-medium leading-relaxed border-t border-slate-50">
                        Anda dapat melakukan edit mandiri jika status data belum divalidasi oleh panitia pusat. Silakan masuk ke dashboard, pilih menu Biodata, dan lakukan perbaikan. Jika tombol kunci telah aktif, Anda wajib membawa dokumen bukti ke helpdesk sekolah.
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- FOOTER -->
    <footer class="bg-[#0f172a] text-slate-400 pt-16 pb-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-6">
            
            <!-- Grid Konten Utama Footer -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 pb-12 border-b border-slate-800/60">
                
                <!-- Kolom 1: Branding & Deskripsi Singkat -->
                <div class="md:col-span-5 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold shadow-lg shadow-indigo-600/10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                            </svg>
                        </div>
                        <span class="text-base font-extrabold text-white uppercase tracking-wider">Sidu-Apps</span>
                    </div>
                    <p class="text-sm text-slate-400 font-medium leading-relaxed max-w-sm">
                        Sistem Informasi Daftar Ulang terintegrasi untuk kemudahan calon peserta didik baru di SMK Negeri 1 Kawali.
                    </p>
                </div>

                <!-- Kolom 2: Informasi Alamat & Kontak Sekolah -->
                <div class="md:col-span-4 space-y-3">
                    <h5 class="text-xs font-bold text-slate-200 uppercase tracking-wider">Kontak & Alamat</h5>
                    <ul class="space-y-2.5 text-sm font-medium">
                        <li class="flex items-start gap-2.5 leading-relaxed">
                            <svg class="w-4 h-4 text-slate-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Jl. Talagasari No. 35, Kawali, Kec. Kawali, Kabupaten Ciamis, Jawa Barat 46253</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span>(0265) 791707</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <svg class="w-4 h-4 text-slate-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span>smkn1kawali@gmail.com</span>
                        </li>
                    </ul>
                </div>

                <!-- Kolom 3: Media Sosial -->
                <div class="md:col-span-3 space-y-3">
                    <h5 class="text-xs font-bold text-slate-200 uppercase tracking-wider">Media Sosial</h5>
                    <div class="flex items-center gap-3">
                        <!-- Instagram -->
                        <a href="https://instagram.com/smkn1kawali" target="_blank" class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-indigo-600 text-slate-400 hover:text-white flex items-center justify-center transition shadow-sm" title="Instagram">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zM17.5 6.5h.01"/>
                            </svg>
                        </a>
                        <!-- YouTube -->
                        <a href="https://youtube.com/@SMKN1KawaliOfficial" target="_blank" class="w-9 h-9 rounded-xl bg-slate-800 hover:bg-rose-600 text-slate-400 hover:text-white flex items-center justify-center transition shadow-sm" title="YouTube">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Bagian Hak Cipta (Bottom Bar) -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs font-medium text-slate-500 text-center sm:text-left">
                    &copy; 2026 TEFA RPL | SMK Negeri 1 Kawali. Seluruh hak cipta dilindungi undang-undang.
                </p>
                <div class="flex gap-4 text-[11px] font-semibold text-slate-500">
                    <a href="#" class="hover:text-slate-400 transition">Kebijakan Privasi</a>
                    <span>•</span>
                    <a href="#" class="hover:text-slate-400 transition">Syarat & Ketentuan</a>
                </div>
            </div>

        </div>
    </footer>

</body>

</html>