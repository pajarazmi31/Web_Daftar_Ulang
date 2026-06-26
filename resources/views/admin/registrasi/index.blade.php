@extends('layouts.dashboard')

@section('title', 'Data Registrasi Peserta Didik')
@section('header_title', 'Registrasi & Berkas Berkas')
@section('header_subtitle', 'Kelola berkas fisik, penetapan keahlian jurusan, dan verifikasi status siswa baru.')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">


    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-500 shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                </svg>
        </div>
        <div>
            <span class="block text-xs font-medium text-slate-400 uppercase tracking-wider">Total Registrasi</span>
            <span class="text-2xl font-bold text-indigo-600">{{ $totalRegistrasi ?? 0 }}</span>
        </div>
    </div>

    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500 shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <span class="block text-xs font-medium text-slate-400 uppercase tracking-wider">Menunggu Verifikasi</span>
            <span class="text-2xl font-bold text-amber-600">{{ $countPending ?? 0 }}</span>
        </div>
    </div>

    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-500 shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <span class="block text-xs font-medium text-slate-400 uppercase tracking-wider">Berkas Diterima</span>
            <span class="text-2xl font-bold text-emerald-600">{{ $countDisetujui ?? 0 }}</span>
        </div>
    </div>

    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500 shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <span class="block text-xs font-medium text-slate-400 uppercase tracking-wider">Berkas Ditolak</span>
            <span class="text-2xl font-bold text-rose-600">{{ $countDitolak ?? 0 }}</span>
        </div>
    </div>
</div>

<form action="{{ url()->current() }}" method="GET" class="w-full bg-white p-4 rounded-2xl border border-slate-100 mb-6 flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-4 shadow-sm">

    <div class="relative flex-1 max-w-md flex items-center">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </span>

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari nama, NISN, atau sekolah asal..."
            class="w-full pl-10 pr-24 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:bg-white transition-all text-slate-700">

        <div class="absolute inset-y-0 right-0 flex items-center pr-4 gap-3">
            @if(request('search') || request('jurusan') || request('status'))
            <a href="{{ url()->current() }}" class="text-xs text-slate-400 hover:text-slate-600 font-medium transition-colors px-1" title="Clear semua filter">
                Reset
            </a>
            <span class="h-4 w-px bg-slate-200"></span>
            @endif
            <button class="text-xs text-slate-400 hover:text-slate-600 font-medium transition-colors">Cari</button>
        </div>

    </div>

    <div class="flex flex-wrap items-center gap-2">
        {{-- Filter Jurusan --}}
        <select name="jurusan" onchange="this.form.submit()" class="px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:bg-white transition-all text-slate-600">
            <option value="">Semua Jurusan</option>
            <option value="Teknik Otomotif" {{ request('jurusan') == 'Teknik Otomotif' ? 'selected' : '' }}>Teknik Otomotif</option>
            <option value="Teknik Jaringan Komputer dan Telekomunikasi" {{ request('jurusan') == 'Teknik Jaringan Komputer dan Telekomunikasi' ? 'selected' : '' }}>TKJT (TKJ)</option>
            <option value="Pengembangan Perangkat Lunak dan Gim" {{ request('jurusan') == 'Pengembangan Perangkat Lunak dan Gim' ? 'selected' : '' }}>PPLG (RPL)</option>
            <option value="Desain Pemodelan dan Informasi Bangunan" {{ request('jurusan') == 'Desain Pemodelan dan Informasi Bangunan' ? 'selected' : '' }}>DPIB</option>
            <option value="Manajemen Perkantoran dan Layanan Bisnis" {{ request('jurusan') == 'Manajemen Perkantoran dan Layanan Bisnis' ? 'selected' : '' }}>MPLB</option>
            <option value="Akuntansi dan Keuangan Lembaga" {{ request('jurusan') == 'Akuntansi dan Keuangan Lembaga' ? 'selected' : '' }}>AKL</option>
            <option value="Seni Pertunjukan" {{ request('jurusan') == 'Seni Pertunjukan' ? 'selected' : '' }}>Seni Pertunjukan</option>
        </select>

        {{-- Filter Status --}}
        <select name="status" onchange="this.form.submit()" class="px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:bg-white transition-all text-slate-600">
            <option value="">Semua Status</option>
            <option value="Menunggu Verifikasi" {{ request('status') == 'Menunggu Verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
            <option value="Diterima" {{ request('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
        </select>
    </div>

    <a href="{{ route('registrasi.create') }}" class="flex items-center justify-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-medium shadow-sm transition-all duration-150 whitespace-nowrap lg:ml-auto">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7-7H5" />
        </svg>
        Tambah Peserta
    </a>
</form>

<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                    <th class="px-6 py-4 w-16 text-center">No</th>
                    <th class="py-4 px-6">Siswa</th>
                    <th class="py-4 px-6">Pilihan Jurusan</th>
                    <th class="py-4 px-6">Status</th>
                    <th class="py-4 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                {{-- Ganti $registrasis dengan variabel loop asli Anda dari Controller, contoh: @foreach($registrasi as $item) --}}
                @forelse($registrasis ?? [] as $item)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="px-6 py-4 text-center text-slate-400 font-medium">{{ $loop->iteration }}</td>
                    <td class="py-4 px-6">
                        <div class="font-semibold text-slate-700">{{ $item->pesertadidik->nama_lengkap ?? 'Nama Tidak Ada' }}</div>
                        <div class="text-xs text-slate-400 mt-0.5">NISN: {{ $item->pesertadidik->nisn ?? '-' }}</div>
                    </td>
                    <td class="py-4 px-6">
                        <span class="font-medium text-slate-700">{{ $item->pesertadidik->kompetensi_keahlian ?? '-' }}</span>
                    </td>
                    <td class="py-4 px-6">
                        {{-- Penyederhanaan Logika Warna Badge Status --}}
                        @if(($item->status_registrasi ?? 'Menunggu Verifikasi') === 'Diterima')
                        <span class="w-8 h-8 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-500 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        @elseif(($item->status_registrasi ?? 'Menunggu Verifikasi') === 'Ditolak')
                        <span class="w-8 h-8 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        @else
                        <span class="w-8 h-8 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                        @endif
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center justify-center gap-1">
                            <a href="{{ route('registrasi.detail', $item->id) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Lihat Detail & Verifikasi">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a href="{{ route('registrasi.edit', $item->id) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Ubah Biodata">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                </svg>
                            </a>
                            <form action="{{ route('registrasi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berkas registrasi ini?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus Data">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-slate-400">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-4m-8 0H4" />
                            </svg>
                            <span>Belum ada data pendaftaran masuk.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
            @if($registrasis->hasPages())
        <div class="px-6 py-4 bg-white border-t border-slate-100 flex items-center justify-between">
            <div class="text-xs text-slate-500">
                Menampilkan <span class="font-medium text-slate-800">{{ $registrasis->firstItem() }}</span> 
                sampai <span class="font-medium text-slate-800">{{ $registrasis->lastItem() }}</span> 
                dari <span class="font-medium text-slate-800">{{ $registrasis->total() }}</span> peserta
            </div>

            <div class="flex items-center gap-2">
                {{-- Tombol Previous --}}
                @if ($registrasis->onFirstPage())
                    <span class="cursor-not-allowed opacity-40 inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-slate-400 bg-slate-50 border border-slate-200 rounded-lg select-none">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                        Sebelumnya
                    </span>
                @else
                    <a href="{{ $registrasis->previousPageUrl() }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 border border-indigo-100 rounded-lg transition-colors duration-150">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                        Sebelumnya
                    </a>
                @endif

                {{-- Status Halaman Aktif (Contoh: 1 / 12) --}}
                <span class="text-xs font-medium text-slate-600 px-2">
                    {{ $registrasis->currentPage() }} <span class="text-slate-300">/</span> {{ $registrasis->lastPage() }}
                </span>

                {{-- Tombol Next --}}
                @if ($registrasis->hasMorePages())
                    <a href="{{ $registrasis->nextPageUrl() }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 border border-indigo-100 rounded-lg transition-colors duration-150">
                        Selanjutnya
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                    </a>
                @endif
            </div>
        </div>
        @endif
</div>
@endsection