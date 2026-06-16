@extends('layouts.dashboard')

@section('title', 'Data Registrasi Peserta Didik')
@section('header_title', 'Registrasi & Berkas Berkas')

@section('content')
<div class="max-w-7xl mx-auto bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50">
        <div>
            <h3 class="text-lg font-bold text-slate-800">Daftar Dokumen & Status Registrasi</h3>
            <p class="text-xs text-slate-500">Kelola berkas fisik, penetapan keahlian jurusan, dan verifikasi status siswa baru.</p>
        </div>
        <a href="{{ route('registrasi.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-xl font-semibold text-sm hover:bg-indigo-700 transition shadow-sm">
            + Tambah Registrasi Berkas
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-100 text-slate-600 font-semibold text-xs uppercase tracking-wider border-b border-slate-200">
                    <th class="p-4">Nama Siswa / NIK</th>
                    <th class="p-4">Kompetensi Keahlian</th>
                    <th class="p-4">Jenis Pendaftaran</th>
                    <th class="p-4">Asal Sekolah</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                @forelse($registrasi as $reg)
                <tr class="hover:bg-slate-50/70 transition">
                    <td class="p-4">
                        <div class="font-bold text-slate-800">{{ $reg->pesertaDidik->nama_lengkap ?? 'Siswa Terhapus' }}</div>
                        <div class="text-xs text-slate-400 font-mono">{{ $reg->pesertaDidik->nik ?? '-' }}</div>
                    </td>
                    <td class="p-4 font-medium">{{ $reg->kompetensi_keahlian ?? '-' }}</td>
                    <td class="p-4"><span class="px-2.5 py-1 bg-slate-100 rounded-md text-xs font-semibold">{{ $reg->jenis_pendaftaran }}</span></td>
                    <td class="p-4 text-slate-500">{{ $reg->sekolah_asal ?? '-' }}</td>
                    <td class="p-4">
                        @if($reg->status_registrasi == 'Diterima')
                        <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-bold">Diterima</span>
                        @elseif($reg->status_registrasi == 'Menunggu Verifikasi')
                        <span class="px-2.5 py-1 bg-amber-100 text-amber-800 rounded-full text-xs font-bold">Menunggu Verifikasi</span>
                        @elseif($reg->status_registrasi == 'Ditolak')
                        <span class="px-2.5 py-1 bg-rose-100 text-rose-800 rounded-full text-xs font-bold">Ditolak</span>
                        @else
                        <span class="px-2.5 py-1 bg-slate-200 text-slate-700 rounded-full text-xs font-bold">Draft</span>
                        @endif
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('registrasi.detail', $reg->id) }}" class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition" title="Detail Data / Berkas">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </a>

                            <a href="{{ route('registrasi.edit', $reg->id) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Ubah Data">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                </svg>
                            </a>
                            <form action="{{ route('registrasi.destroy', $reg->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus seluruh berkas registrasi ini?')" class="inline">
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
                    <td colspan="6" class="p-8 text-center text-slate-400">Belum ada rekam registrasi berkas pendaftar yang masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection