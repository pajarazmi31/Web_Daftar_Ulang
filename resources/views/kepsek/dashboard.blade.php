@extends('layouts.dashboard')

@section('title', 'Dashboard Kepala Sekolah')

@section('header_title')
Laporan Executive Daftar Ulang
@endsection

@section('header_subtitle')
Halaman pemantauan pendaftaran, kuota daya tampung, dan demografi peserta didik
@endsection

@section('content')
<div class="space-y-8 antialiased text-slate-700">

    <!-- 1. EXECUTIVE SUMMARY CARDS (ANGKA UTAMA) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6">

        <!-- Total Peserta Didik -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6 transition-all duration-200 hover:shadow-md hover:-translate-y-0.5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-sm font-medium tracking-wide">Total Pendaftar</p>
                    <h3 class="text-3xl font-bold tracking-tight text-slate-800 mt-2">
                        {{ $totalPeserta ?? 0 }}
                    </h3>
                </div>
                <div class="p-3 rounded-xl bg-indigo-50 text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Registrasi -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6 transition-all duration-200 hover:shadow-md hover:-translate-y-0.5">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-sm font-medium tracking-wide">Total Registrasi</p>
                    <h3 class="text-3xl font-bold tracking-tight text-amber-600 mt-2">
                        {{ $totalRegistrasi ?? 0 }}
                    </h3>
                </div>
                <div class="p-3 rounded-xl bg-amber-50 text-amber-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. DIAGRAM UTAMA & LAPORAN JURUSAN -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

        <!-- Sisi Kiri: Laporan Keterisian Kuota per Kompetensi Keahlian (Jurusan) -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm lg:col-span-2">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h3 class="text-base font-semibold text-slate-900 tracking-tight">Keterisian Kompetensi Keahlian</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Jumlah siswa yang telah diterima berdasarkan rincian kuota jurusan.</p>
                </div>
                <button class="text-xs font-semibold bg-white border border-slate-200 text-slate-700 px-3 py-1.5 rounded-xl hover:bg-slate-50 transition flex items-center gap-1.5 shadow-sm">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096a42.42 42.42 0 01-10.56 0m10.56 0L17.66 18m0 0a2.25 2.25 0 002.25-2.25v-1.318a3.75 3.75 0 00-2.25-3.436M17.66 18a2.25 2.25 0 01-2.25 2.25H8.59a2.25 2.25 0 01-2.25-2.25M17.66 18.543A3.33 3.33 0 0115.41 20H8.59c-.83 0-1.605-.305-2.2-.816m13.72-6.013A3.747 3.747 0 0012 9a3.747 3.747 0 00-6.11 3.171m12.22 0c.229.215.353.516.353.832v1.319c0 .416-.215.803-.561 1.026M5.89 13.171a3.747 3.747 0 00-3.39 3.437v1.318a2.25 2.25 0 002.25 2.25m0 0a2.25 2.25 0 002.25-2.25v-1.319c0-.316.124-.617.353-.832m1.11-4.171a41.077 41.077 0 0110.56 0M10.5 7.5h3" />
                    </svg>
                    <span>Cetak Laporan</span>
                </button>
            </div>

            <div class="space-y-5">
                @forelse($rekapJurusan ?? [] as $jurusan)
                <div>
                    @php
                    // 1. Tentukan batas kuota maksimal berdasarkan nama/inisial jurusan di database Anda
                    $namaJurusan = $jurusan->kompetensi_keahlian ?? '';

                    if (str_contains($namaJurusan, 'PPLG') || str_contains($namaJurusan, 'Pengembangan Perangkat Lunak')) {
                    $quotaMax = 108;
                    } elseif (str_contains($namaJurusan, 'TJKT') || str_contains($namaJurusan, 'Jaringan Komputer')) {
                    $quotaMax = 108;
                    } elseif (str_contains($namaJurusan, 'TO') || str_contains($namaJurusan, 'Otomotif')) {
                    $quotaMax = 108;
                    } elseif (str_contains($namaJurusan, 'DPIB') || str_contains($namaJurusan, 'Pemodelan')) {
                    $quotaMax = 72;
                    } elseif (str_contains($namaJurusan, 'AKL') || str_contains($namaJurusan, 'Akuntansi')) {
                    $quotaMax = 108;
                    } elseif (str_contains($namaJurusan, 'MPLB') || str_contains($namaJurusan, 'Perkantoran')) {
                    $quotaMax = 72;
                    } elseif (str_contains($namaJurusan, 'Karawitan') || str_contains($namaJurusan, 'Pertunjukan')) {
                    $quotaMax = 72;
                    } else {
                    $quotaMax = 100; // Kuota default jika nama tidak cocok atau untuk data umum
                    }

                    // 2. Hitung persentase keterisian secara akurat
                    $totalSiswa = $jurusan->total ?? 0;
                    $persen = $quotaMax > 0 ? min(($totalSiswa / $quotaMax) * 100, 100) : 0;
                    @endphp

                    <div class="flex justify-between text-xs font-medium text-slate-700 mb-1.5">
                        <span>{{ $namaJurusan ?: 'Umum / Belum Mengisi' }}</span>
                        <span class="text-slate-500 font-semibold">{{ $totalSiswa }} <span class="text-slate-400 font-normal">/ {{ $quotaMax }} Siswa</span></span>
                    </div>

                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                        {{-- Mengubah warna bar menjadi indigo agar tampak lebih modern dan hidup --}}
                        <div class="bg-indigo-600 h-full rounded-full transition-all duration-500" style="width: {{ $persen }}%"></div>
                    </div>
                </div>
                @empty
                <div class="py-8 text-center text-xs text-slate-400 italic">
                    Belum ada data siswa yang resmi diterima pada jurusan manapun.
                </div>
                @endforelse
            </div>
        </div>
        <!-- Komponen 2: Top Asal Sekolah (Feeder) -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
            <h3 class="text-base font-semibold text-slate-900 tracking-tight mb-2">Top 3 Asal Sekolah Terbanyak</h3>
            <p class="text-xs text-slate-400 mb-4">Sekolah asal yang paling banyak menyumbang calon peserta didik.</p>

            <div class="space-y-3">
                @forelse($topSekolahAsal ?? [] as $sekolah)
                <div class="flex justify-between items-center p-2.5 hover:bg-slate-50 rounded-xl transition">
                    <div class="flex items-center space-x-3 text-sm">
                        <!-- Mengganti Emoji Gedung Sekolah Tradisional -->
                        <div class="text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                            </svg>
                        </div>
                        <span class="font-medium text-slate-700">{{ $sekolah->sekolah_asal ?? 'Tidak Diketahui' }}</span>
                    </div>
                    <span class="text-xs bg-slate-100 px-2.5 py-1 rounded-full font-semibold text-slate-600">
                        {{ $sekolah->total }} Siswa
                    </span>
                </div>
                @empty
                <p class="text-xs text-slate-400 italic py-4 text-center">Belum ada rincian data sekolah asal.</p>
                @endforelse
            </div>
        </div>


    </div>

    <!-- 3. ANALISIS TAMBAHAN -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-8">
        <!-- Sisi Kanan: Demografi Ringkas & Informasi Tambahan -->
        <div class="space-y-4 lg:col-span-1">

            <!-- Card Komposisi Gender -->
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Proporsi Gender Terdata</h3>

                <div class="space-y-4">
                    <!-- Laki-laki (Mengganti Emoji Topi Toga Laki-laki) -->
                    <div class="flex items-center justify-between p-3 bg-blue-50/50 rounded-xl">
                        <div class="flex items-center space-x-3 text-sm">
                            <div class="p-1.5 rounded-lg bg-blue-50 text-blue-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.263 15.918a9 9 0 0015.474 0M12 12a3 3 0 100-6 3 3 0 000 6zm0 0v6m-3-3h6" />
                                </svg>
                            </div>
                            <span class="font-medium text-slate-700">Laki-laki</span>
                        </div>
                        <span class="text-sm font-semibold text-blue-700">{{ $pria ?? 0 }} <span class="text-xs text-slate-400 font-normal">Siswa</span></span>
                    </div>

                    <!-- Perempuan (Mengganti Emoji Topi Toga Perempuan) -->
                    <div class="flex items-center justify-between p-3 bg-rose-50/50 rounded-xl">
                        <div class="flex items-center space-x-3 text-sm">
                            <div class="p-1.5 rounded-lg bg-rose-50 text-rose-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 12a3 3 0 100-6 3 3 0 000 6zm0 0v6m-3-2h6m-6-2h6" />
                                </svg>
                            </div>
                            <span class="font-medium text-slate-700">Perempuan</span>
                        </div>
                        <span class="text-sm font-semibold text-rose-700">{{ $wanita ?? 0 }} <span class="text-xs text-slate-400 font-normal">Siswa</span></span>
                    </div>
                </div>
            </div>

        </div>
        <!-- Komponen 1: Analisis Kebutuhan Bantuan (KIP & Beasiswa) -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm lg:col-span-2">
            <div class="mb-5">
                <h3 class="text-base font-semibold text-slate-900 tracking-tight">Analisis Profil Penerima Beasiswa</h3>
                <p class="text-xs text-slate-400 mt-0.5 mb-3">Rincian kuantitas data siswa berdasarkan kategori beasiswa yang diajukan.</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-1 h-full bg-indigo-500"></div>
                    <span class="text-xs text-slate-400 font-medium block mb-1 truncate">Anak Berprestasi</span>
                    <span class="text-2xl font-bold text-slate-800 block leading-none my-1">
                        {{ $beasiswaBerprestasi ?? 0 }}
                    </span>
                </div>

                <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-1 h-full bg-amber-500"></div>
                    <span class="text-xs text-slate-400 font-medium block mb-1 truncate">Bantuan Afirmasi</span>
                    <span class="text-2xl font-bold text-slate-800 block leading-none my-1">
                        {{ $beasiswaMiskin ?? 0 }}
                    </span>
                </div>

                <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-1 h-full bg-emerald-500"></div>
                    <span class="text-xs text-slate-400 font-medium block mb-1 truncate">Pendidikan</span>
                    <span class="text-2xl font-bold text-slate-800 block leading-none my-1">
                        {{ $beasiswaPendidikan ?? 0 }}
                    </span>
                </div>

                <div class="p-4 bg-slate-50 border border-slate-100 rounded-xl relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-1 h-full bg-sky-500"></div>
                    <span class="text-xs text-slate-400 font-medium block mb-1 truncate">Unggulan</span>
                    <span class="text-2xl font-bold text-slate-800 block leading-none my-1">
                        {{ $beasiswaUnggulan ?? 0 }}
                    </span>
                </div>
            </div>
        </div>



    </div>
</div>
@endsection