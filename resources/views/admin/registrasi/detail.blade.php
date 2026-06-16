@extends('layouts.dashboard')

@section('title', 'Detail Registrasi Peserta Didik')
@section('header_title', 'Detail Berkas & Registrasi')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <a href="{{ route('registrasi.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-800 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Kembali ke Daftar
        </a>
        <a href="{{ route('registrasi.edit', $registrasi->id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-xl font-semibold text-sm hover:bg-indigo-700 transition shadow-sm">
            Ubah Data
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h3 class="text-lg font-bold text-slate-800">{{ $registrasi->pesertaDidik->nama_lengkap ?? 'Siswa Terhapus' }}</h3>
                <p class="text-xs text-slate-400 font-mono mt-1">NIK: {{ $registrasi->pesertaDidik->nik ?? '-' }}</p>
            </div>
            <div>
                @if($registrasi->status_registrasi == 'Diterima')
                <span class="px-3 py-1.5 bg-emerald-100 text-emerald-800 rounded-full text-xs font-bold shadow-sm shadow-emerald-100/50">Diterima</span>
                @elseif($registrasi->status_registrasi == 'Menunggu Verifikasi')
                <span class="px-3 py-1.5 bg-amber-100 text-amber-800 rounded-full text-xs font-bold shadow-sm shadow-amber-100/50">Menunggu Verifikasi</span>
                @elseif($registrasi->status_registrasi == 'Ditolak')
                <span class="px-3 py-1.5 bg-rose-100 text-rose-800 rounded-full text-xs font-bold shadow-sm shadow-rose-100/50">Ditolak</span>
                @else
                <span class="px-3 py-1.5 bg-slate-200 text-slate-700 rounded-full text-xs font-bold">Draft</span>
                @endif
            </div>
        </div>

        <div class="p-6 space-y-6">
            <div>
                <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider mb-3">I. Informasi Pendaftaran</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-slate-50/50 p-4 rounded-xl border border-slate-100">
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Kompetensi Keahlian Jurusan</span>
                        <span class="text-sm font-semibold text-slate-700">{{ $registrasi->kompetensi_keahlian ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Jenis Pendaftaran</span>
                        <span class="text-sm font-semibold text-slate-700">{{ $registrasi->jenis_pendaftaran }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Sekolah Asal</span>
                        <span class="text-sm font-semibold text-slate-700">{{ $registrasi->sekolah_asal ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Pernah PAUD?</span>
                        <span class="text-sm font-semibold text-slate-700">{{ $registrasi->pernah_paud }}</span>
                    </div>
                </div>
            </div>

            <div>
                <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider mb-3">II. Data Minat & Bakat</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-slate-50/50 p-4 rounded-xl border border-slate-100">
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Hobi</span>
                        <span class="text-sm font-semibold text-slate-700">{{ $registrasi->hobi ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Cita-Cita</span>
                        <span class="text-sm font-semibold text-slate-700">{{ $registrasi->cita_cita ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div>
                <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider mb-3">III. Lampiran Dokumen Scan Berkas</h4>
                <div class="border border-slate-100 rounded-xl overflow-hidden divide-y divide-slate-100">
                    {{-- DI SINI PERBAIKANNYA: @th diganti menjadi @foreach --}}
                    @foreach([
                        'kk' => 'Kartu Keluarga (KK)',
                        'ktp_ortu' => 'KTP Orang Tua',
                        'akta_kelahiran' => 'Akta Kelahiran',
                        'surat_keterangan_lulus' => 'Surat Keterangan Lulus (SKL)',
                        'kartu_kesejahteraan' => 'Kartu Kesejahteraan (KKS/KPS)',
                        'sptjm' => 'SPTJM Berkas',
                        'surat_pernyataan_tata_tertib' => 'Surat Pernyataan Tata Tertib Sekolah'
                    ] as $field => $label)
                    <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2 hover:bg-slate-50/50 transition">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            <span class="text-sm font-medium text-slate-700">{{ $label }}</span>
                        </div>
                        <div>
                            @if($registrasi->$field)
                            <a href="{{ asset('storage/' . $registrasi->$field) }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:text-indigo-800 bg-indigo-50 px-3 py-1.5 rounded-lg transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Lihat Dokumen
                            </a>
                            @else
                            <span class="text-xs font-medium text-slate-400 bg-slate-100 px-3 py-1.5 rounded-lg select-none">Belum Diupload</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection