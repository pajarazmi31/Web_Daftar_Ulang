@extends('layouts.dashboard')

@section('title', 'Dashboard Kepala Sekolah')

@section('header_title')
Laporan Eksekutif Daftar Ulang
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
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
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
                    <p class="text-xs text-slate-400 mt-0.5">Jumlah siswa yang telah diterima berdasarkan rincian jurusan.</p>
                </div>
                <!-- Tombol Cetak Laporan Cepat -->
                <button onclick="window.print()" class="text-xs font-semibold bg-slate-50 border border-slate-200 text-slate-700 px-3 py-1.5 rounded-xl hover:bg-slate-100 transition flex items-center space-x-1">
                    <span>🖨️</span> <span>Cetak Laporan</span>
                </button>
            </div>

            <div class="space-y-5">
                @forelse($rekapJurusan ?? [] as $jurusan)
                <div>
                    <div class="flex justify-between text-xs font-medium text-slate-700 mb-1.5">
                        <span>{{ $jurusan->kompetensi_keahlian ?? 'Umum / Belum Mengisi' }}</span>
                        <span class="text-slate-500">{{ $jurusan->total }} Siswa</span>
                    </div>
                    <!-- Progress Bar Minimalis -->
                    <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                        {{-- Contoh logic dinamis persentase jika ada target kuota, misal target maksimal 100 siswa per jurusan --}}
                        @php $persen = min(($jurusan->total / 100) * 100, 100); @endphp
                        <div class="bg-slate-900 h-full rounded-full transition-all duration-500" style="width: {{ $persen }}%"></div>
                    </div>
                </div>
                @empty
                <div class="py-8 text-center text-xs text-slate-400 italic">
                    Belum ada data siswa yang resmi diterima pada jurusan manapun.
                </div>
                @endforelse
            </div>
        </div>

        <!-- Sisi Kanan: Demografi Ringkas & Informasi Tambahan -->
        <div class="space-y-6 lg:col-span-1">
            
            <!-- Card Komposisi Gender -->
            <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Proporsi Gender Terdata</h3>
                
                <div class="space-y-4">
                    <!-- Laki-laki -->
                    <div class="flex items-center justify-between p-3 bg-blue-50/50 rounded-xl">
                        <div class="flex items-center space-x-3 text-sm">
                            <span class="text-lg">👨‍🎓</span>
                            <span class="font-medium text-slate-700">Laki-laki</span>
                        </div>
                        <span class="text-sm font-semibold text-blue-700">{{ $pria ?? 0 }} <span class="text-xs text-slate-400 font-normal">Siswa</span></span>
                    </div>

                    <!-- Perempuan -->
                    <div class="flex items-center justify-between p-3 bg-rose-50/50 rounded-xl">
                        <div class="flex items-center space-x-3 text-sm">
                            <span class="text-lg">👩‍🎓</span>
                            <span class="font-medium text-slate-700">Perempuan</span>
                        </div>
                        <span class="text-sm font-semibold text-rose-700">{{ $wanita ?? 0 }} <span class="text-xs text-slate-400 font-normal">Siswa</span></span>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- TAMBAHKAN BARIS BARU INI DI BAWAH GRID UTAMA DASHBOARD KEPALA SEKOLAH -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">

    <!-- Komponen 1: Analisis Kebutuhan Bantuan (KIP & Beasiswa) -->
    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
        <h3 class="text-base font-semibold text-slate-900 tracking-tight mb-4">Analisis Profil Afirmasi & Beasiswa</h3>
        <div class="grid grid-cols-2 gap-4">
            <div class="p-4 bg-slate-50 rounded-xl">
                <span class="text-xs text-slate-400 block mb-1">Punya KIP (Belum Dapat Bantuan)</span>
                <!-- Menerapkan pengecekan field punya_kip & penerima_kip dari migration -->
                <span class="text-2xl font-semibold text-slate-800">{{ $punyaKipBelumMenerima ?? 0 }}</span>
                <span class="text-xs text-slate-400 block mt-1">Perlu diusulkan ke PIP</span>
            </div>
            <div class="p-4 bg-slate-50 rounded-xl">
                <span class="text-xs text-slate-400 block mb-1">Siswa Jalur Prestasi / Beasiswa</span>
                <span class="text-2xl font-semibold text-indigo-600">{{ $totalBeasiswa ?? 0 }}</span>
                <span class="text-xs text-slate-400 block mt-1">Siswa berprestasi terdata</span>
            </div>
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
                    <span class="text-slate-400 font-medium">🏫</span>
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
</div>
@endsection