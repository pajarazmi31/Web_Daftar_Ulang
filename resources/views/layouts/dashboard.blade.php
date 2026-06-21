<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Registrasi')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        @media print {

            /* Sembunyikan elemen global yang tidak perlu dicetak (seperti sidebar atau navbar dari dashboard) */
            .print\:hidden,
            nav,
            aside,
            header,
            footer {
                display: none !important;
            }

            /* Hilangkan efek bayangan berat dan transisi yang membebani memori browser saat printing */
            * {
                box-shadow: none !important;
                text-shadow: none !important;
                transition: none !important;
                background-color: transparent !important;
            }

            /* Pastikan kontainer utama mengambil lebar penuh halaman */
            body,
            .space-y-6 {
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }
        }
    </style>

    @vite(['resources/css/app.css','resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-[#f8fafc] text-slate-800 antialiased">

    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">

        <div
            x-show="sidebarOpen"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 lg:hidden"
            @click="sidebarOpen = false">
        </div>

        <aside
            class="fixed lg:static inset-y-0 left-0 z-50 w-60 bg-[#0f172a] text-slate-300 transform transition-transform duration-300 lg:translate-x-0 border-r border-slate-800 flex flex-col justify-between"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

            <div>
                <div class="h-20 flex items-center px-6 border-b border-slate-800/60 gap-3">
                    <div class="w-9 h-9 rounded-xl bg-indigo-600 flex items-center justify-center text-white font-bold shadow-md shadow-indigo-600/20">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="font-bold text-sm tracking-wide text-white uppercase">Sidu-Apps</h1>
                        <p class="text-[11px] text-slate-500 font-medium">SMK NEGERI 1 KAWALI</p>
                    </div>
                </div>

                <nav class="p-4 space-y-1">

                    {{-- ADMIN ROLE ONLY --}}
                    @if(auth()->user()->role->nama_role == 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/10' : 'hover:bg-slate-800/50 hover:text-white text-slate-400' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                        </svg>
                        <span class="text-sm">Dashboard</span>
                    </a>
                    <a href="{{ route('manajemen_akun') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition group {{ request()->routeIs('manajemen_akun') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/10' : 'hover:bg-slate-800/50 hover:text-white text-slate-400' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('manajemen_akun') ? 'text-white' : 'text-slate-400 group-hover:text-slate-200' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span class="text-sm">Manajemen Akun</span>
                    </a>

                    <div class="pt-4 pb-1 px-4 text-[10px] uppercase font-bold tracking-wider text-slate-600">Fitur Utama</div>

                    <a href="{{ route('data-peserta.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition group {{ request()->routeIs('data-peserta.index') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/10' : 'hover:bg-slate-800/50 hover:text-white text-slate-400' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                        <span class="text-sm">Data Peserta Didik</span>
                    </a>

                    <a href="{{ route('registrasi.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition group {{ request()->routeIs('registrasi.index') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/10' : 'hover:bg-slate-800/50 hover:text-white text-slate-400' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span class="text-sm">Registrasi</span>
                    </a>
                    @endif

                    {{-- OPERATOR ROLE ONLY --}}
                    @if(auth()->user()->role->nama_role == 'operator')
                    <a href="{{ route('operator.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition {{ request()->routeIs('operator.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/10' : 'hover:bg-slate-800/50 hover:text-white text-slate-400' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                        </svg>
                        <span class="text-sm">Dashboard</span>
                    </a>

                    <div class="pt-4 pb-1 px-4 text-[10px] uppercase font-bold tracking-wider text-slate-600">Fitur Utama</div>

                    <a href="{{ route('data-peserta.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition group {{ request()->routeIs('data-peserta.index') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/10' : 'hover:bg-slate-800/50 hover:text-white text-slate-400' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                        </svg>
                        <span class="text-sm">Data Peserta Didik</span>
                    </a>

                    <a href="{{ route('registrasi.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition group {{ request()->routeIs('registrasi.index') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/10' : 'hover:bg-slate-800/50 hover:text-white text-slate-400' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span class="text-sm">Registrasi</span>
                    </a>
                    @endif

                    {{-- FITUR KHUSUS SISWA --}}
                    @if(auth()->user()->role->nama_role == 'siswa')
                    <div class="pt-4 pb-1 px-4 text-[10px] uppercase font-bold tracking-wider text-slate-600">Menu Siswa</div>

                    <a href="{{ route('siswa.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition {{ request()->routeIs('siswa.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/10' : 'hover:bg-slate-800/50 hover:text-white text-slate-400' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                        </svg>
                        <span class="text-sm">Dashboard</span>
                    </a>
                    <a href="{{ route('siswa.data-diri.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition group {{ request()->routeIs('siswa.data-diri.index') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/10' : 'hover:bg-slate-800/50 hover:text-white text-slate-400' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-sm">Data Diri Anda</span>
                    </a>
                    <a href="{{ route('registrasi.siswa') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition group {{ request()->routeIs('registrasi.siswa') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/10' : 'hover:bg-slate-800/50 hover:text-white text-slate-400' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span class="text-sm">Registrasi Mandiri</span>
                    </a>
                    @endif

                    {{-- KEPSEK --}}
                    @if(auth()->user()->role->nama_role == 'kepsek')
                    <a href="{{ route('kepsek.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition {{ request()->routeIs('kepsek.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/10' : 'hover:bg-slate-800/50 hover:text-white text-slate-400' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                        </svg>
                        <span class="text-sm">Dashboard</span>
                    </a>
                    <a href="{{ route('laporan.kepsek') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition group {{ request()->routeIs('laporan.kepsek') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/10' : 'hover:bg-slate-800/50 hover:text-white text-slate-400' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10a2 2 0 01-2 2h-2a2 2 0 01-2-2zm9 0v-4a2 2 0 00-2-2h-2a2 2 0 00-2 2v4a2 2 0 002 2h2a2 2 0 002-2z" />
                        </svg>
                        <span class="text-sm">Laporan</span>
                    </a>
                    @endif

                    {{-- TOMBOL LOGOUT SIDEBAR --}}
                    <button type="button"
                        onclick="event.preventDefault(); document.getElementById('logout-form-global').submit();"
                        class="w-full flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition group text-slate-400 hover:bg-slate-800/50 hover:text-rose-400 text-left">
                        <svg class="w-5 h-5 text-rose-500 group-hover:text-rose-400 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span class="text-sm">Keluar</span>
                    </button>

                </nav>
            </div>

            <div class="p-4 border-t border-slate-800/60">
                <div class="text-[10px] text-center text-slate-600 font-medium">&copy; 2026 TEFA RPL | SMKN 1 Kawali.</div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">

            <header class="bg-white border-b border-slate-100">
                <div class="flex justify-between items-center h-20 px-6 sm:px-8">

                    <div class="flex items-center gap-4">
                        <button
                            @click="sidebarOpen = true"
                            class="lg:hidden text-slate-600 hover:text-slate-900 focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24 " stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <div>
                            <h2 class="font-bold text-lg sm:text-xl text-slate-800 tracking-tight">
                                @yield('header_title')
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-400 font-medium mt-0.5 hidden sm:block">
                                @yield('header_subtitle')
                            </p>
                        </div>
                    </div>

                    <div x-data="{ open: false }" class="relative">
                        <button
                            @click="open = !open"
                            class="flex items-center gap-3 p-1.5 rounded-xl hover:bg-slate-50 transition focus:outline-none">

                            <div class="text-right hidden sm:block pl-2">
                                <h4 class="font-semibold text-xs text-slate-800">
                                    {{ auth()->user()->name }}
                                </h4>
                                <p class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded mt-0.5 capitalize inline-block">
                                    {{ auth()->user()->role->nama_role }}
                                </p>
                            </div>

                            <div class="w-10 h-10 rounded-xl bg-slate-100 border border-slate-200 text-slate-700 flex items-center justify-center font-bold text-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        </button>

                        <div
                            x-show="open"
                            @click.outside="open = false"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 bg-white rounded-xl shadow-xl border border-slate-100 w-52 overflow-hidden z-50">

                            <div class="px-4 py-3 bg-slate-50/50 border-b border-slate-100 sm:hidden">
                                <p class="text-xs font-semibold text-slate-800">{{ auth()->user()->name }}</p>
                                <p class="text-[10px] text-slate-400 capitalize">{{ auth()->user()->role->nama_role }}</p>
                            </div>

                            <hr class="border-slate-100">

                            {{-- TOMBOL LOGOUT DROPDOWN --}}
                            <button type="button"
                                onclick="event.preventDefault(); document.getElementById('logout-form-global').submit();"
                                class="w-full flex items-center gap-2.5 px-4 py-3 text-sm text-slate-600 hover:bg-slate-50 hover:text-rose-600 transition text-left">
                                <svg class="w-4 h-4 text-slate-400 group-hover:text-rose-500 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span>Keluar</span>
                            </button>
                        </div>
                    </div>

                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-6 sm:p-8">

                @if(session('success'))
                <div x-data="{ show: true }"
                    x-show="show"
                    x-init="setTimeout(() => show = false, 4000)"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 focus:outline-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                @endif

                @if(session('error'))
                <div x-data="{ show: true }"
                    x-show="show"
                    x-init="setTimeout(() => show = false, 5000)"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-rose-500 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                    <button @click="show = false" class="text-rose-400 hover:text-rose-600 focus:outline-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                @endif

                @yield('content')

            </main>

        </div>
    </div>

    {{-- FORM LOGOUT GLOBAL (Ditaruh satu saja di sini agar bisa dipanggil dari mana pun) --}}
    <form id="logout-form-global" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

</body>

</html>