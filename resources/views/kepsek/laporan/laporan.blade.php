@extends('layouts.dashboard')

@section('title', 'Laporan Detail Peserta Didik')

@section('header_title')
Laporan Detail Gabungan Peserta Didik
@endsection

@section('header_subtitle')
Integrasi data profil pribadi dengan status registrasi dan kompetensi keahlian siswa
@endsection

@section('content')
<div class="space-y-6 antialiased text-slate-700">

    <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm">
        <form method="GET" action="{{ route('laporan.kepsek') }}" class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">

            <div class="flex flex-wrap items-center gap-4">
                <div class="w-full sm:w-64">
                    <label for="jurusan" class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Kompetensi Keahlian</label>
                    <select name="jurusan" id="jurusan" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                        <option value="">-- Semua Kompetensi Keahlian --</option>
                        @foreach($daftarJurusan as $jurusan)
                        <option value="{{ $jurusan }}" {{ request('jurusan') == $jurusan ? 'selected' : '' }}>{{ $jurusan }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="pt-6">
                    <button type="submit" class="bg-slate-100 hover:bg-slate-200 text-sm font-medium px-4 py-2 rounded-xl transition duration-150 shadow-sm flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-slate-600">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="pt-2 md:pt-0">
                <a href="{{ route('laporan.kepsek.export', ['jurusan' => request('jurusan')]) }}" class="bg-emerald-600 hover:bg-emerald-500 text-white text-sm font-medium px-4 py-2 rounded-xl transition duration-150 shadow-sm inline-flex items-center space-x-1.5">
                    <span>Export ke Excel</span>
                </a>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-50/75 text-slate-400 text-xs font-bold uppercase tracking-wider border-b border-slate-100">
                        <th class="px-6 py-4 text-center w-12">No</th>
                        <th class="px-6 py-4">NISN / NIK</th>
                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4">Jurusan Pilihan</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                    @forelse($laporanData as $key => $item)
                    <tr class="hover:bg-slate-50/50 transition duration-150">
                        <td class="px-6 py-4 text-center font-medium text-slate-400">
                            {{ $laporanData->firstItem() + $key }}
                        </td>
                        <td class="px-6 py-4 font-mono text-xs text-slate-500">
                            NS: {{ $item->nisn ?? '-' }} <br> NK: {{ $item->nik }}
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-900">
                            {{ $item->nama_lengkap }}
                        </td>
                        <td class="px-6 py-4 font-medium">
                            {{ $item->kompetensi_keahlian ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center">
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
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('laporan.kepsek.detail', $item->id) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition inline-block" title="Lihat Detail Lengkap">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center py-12 text-slate-400 italic text-sm">
                            Tidak ditemukan kecocokan data peserta didik berdasarkan filter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($laporanData->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30">
            {{ $laporanData->links() }}
        </div>
        @endif
    </div>
</div>
</div>
@endsection