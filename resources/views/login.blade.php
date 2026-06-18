<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sidu-Apps</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>

    @vite(['resources/css/app.css','resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-[#f8fafc] text-slate-800 antialiased min-h-screen flex items-center justify-center p-4 sm:p-6 md:p-8">

    <div class="w-full max-w-5xl bg-white rounded-2xl shadow-xl shadow-slate-100/80 overflow-hidden border border-slate-100 grid md:grid-cols-2 min-h-[580px]">
        
        <div class="relative bg-[#0f172a] text-slate-300 p-10 lg:p-14 hidden md:flex flex-col justify-between overflow-hidden border-r border-slate-800">
            <div class="absolute -top-12 -right-12 w-40 h-40 bg-indigo-600/10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -bottom-20 -left-12 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-10">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold shadow-lg shadow-indigo-600/30">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="font-bold text-sm tracking-wide text-white uppercase">Sidu-Apps</h1>
                        <p class="text-[11px] text-slate-500 font-medium">Registrasi Peserta Didik</p>
                    </div>
                </div>

                <div class="space-y-3">
                    <h2 class="text-2xl lg:text-3xl font-bold tracking-tight text-white leading-tight">
                        Sistem Daftar Ulang <br><span class="text-indigo-400">Peserta Didik Baru</span>
                    </h2>
                    <p class="text-slate-400 text-xs lg:text-sm leading-relaxed max-w-sm">
                        Selamat datang di portal administrasi registrasi. Silakan masuk untuk mengelola data penyerahan berkas fisik dan rekam biodata pendaftar sesuai aturan Dapodik.
                    </p>
                </div>
            </div>

            <div class="relative z-10 space-y-3 bg-slate-900/40 border border-slate-800/80 p-5 rounded-xl backdrop-blur-sm max-w-sm">
                @foreach([
                    'Manajemen Biodata Peserta Didik',
                    'Validasi Registrasi & Kelulusan',
                    'Unggah & Verifikasi Berkas Fisik',
                    'Laporan dan Rekapitulasi Sekolah'
                ] as $fitur)
                <div class="flex items-center gap-3 text-xs lg:text-sm font-medium text-slate-300">
                    <svg class="w-4 h-4 text-indigo-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>{{ $fitur }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="p-8 sm:p-12 md:p-10 lg:p-14 flex flex-col justify-between bg-white">
            
            <div class="my-auto space-y-6">
                <div class="text-center md:text-left mb-6">
                    <h3 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">
                        Selamat Datang Kembali
                    </h3>
                    <p class="text-slate-400 text-xs sm:text-sm mt-1.5">
                        Masukkan akun credential Anda untuk mengakses sistem.
                    </p>
                </div>

                {{-- Alert Notification --}}
                @if(session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs sm:text-sm flex items-center gap-3 animate-fade-in">
                    <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
                @endif

                @if($errors->any())
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-1.5">
                    <div class="font-semibold text-rose-900 text-sm flex items-center gap-2">
                        <svg class="w-4 h-4 text-rose-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Gagal Masuk Aplikasi:</span>
                    </div>
                    <ul class="list-disc list-inside space-y-0.5 pl-1 text-slate-600 font-medium">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('login.process') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block mb-1.5 text-xs font-bold text-slate-500 uppercase tracking-wider">
                            Alamat Email
                        </label>
                        <input
                            type="text"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="nama@sekolah.sch.id"
                            required
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/5 transition-all duration-150 placeholder:text-slate-300 font-medium text-slate-800">
                    </div>

                    <div>
                        <label class="block mb-1.5 text-xs font-bold text-slate-500 uppercase tracking-wider">
                            Kata Sandi
                        </label>
                        <input
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            required
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/5 transition-all duration-150 placeholder:text-slate-300 font-medium text-slate-800">
                    </div>

                    <div class="flex items-center justify-between pt-0.5">
                        <label class="flex items-center gap-2.5 cursor-pointer group select-none">
                            <input
                                type="checkbox"
                                name="remember"
                                class="rounded border-slate-200 text-indigo-600 focus:ring-indigo-600/20 w-4 h-4 transition duration-150">
                            <span class="text-xs font-semibold text-slate-500 group-hover:text-slate-700 transition duration-150">
                                Ingat Perangkat Ini
                            </span>
                        </label>
                    </div>

                    <div class="pt-2">
                        <button
                            type="submit"
                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm py-2.5 px-4 rounded-xl shadow-md shadow-indigo-600/10 hover:shadow-lg hover:shadow-indigo-600/20 active:scale-[0.99] transition-all duration-150">
                            Masuk ke Dashboard
                        </button>
                    </div>
                </form>
            </div>

            <div class="mt-8 text-center text-xs font-semibold text-slate-400/90 tracking-wide">
                &copy; {{ date('Y') }} SMK Negeri 1 Kawali. All Rights Reserved.
            </div>

        </div>

    </div>

</body>

</html>