@extends('layouts.dashboard')

@section('title', 'Data Peserta Didik')

@section('header_title', 'Data Peserta Didik')
@section('header_subtitle', 'Master data seluruh calon peserta didik baru.')

@section('content')

<div class="bg-white p-4 rounded-2xl border border-slate-100 mb-6 flex flex-col lg:flex-row justify-between items-stretch lg:items-center gap-4 shadow-sm">
    
    <div class="relative flex-1 max-w-md">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </span>
        <input type="text" placeholder="Cari nama atau NISN..." class="w-full pl-10 pr-4 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:bg-white transition-all">
    </div>

    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 justify-end">
        
        <form action="{{ route('data-peserta.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-2 bg-slate-50 border border-slate-200 p-1.5 rounded-xl w-full sm:w-auto">
            @csrf
            <input type="file" name="file_excel" required class="text-xs text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer w-full sm:w-44">
            <button type="submit" class="text-xs bg-slate-800 text-white px-3 py-1.5 rounded-lg hover:bg-slate-900 transition font-medium whitespace-nowrap shadow-sm">
                Import
            </button>
        </form>

        <a href="{{ route('data-peserta.template') }}" class="text-sm font-medium text-indigo-600 bg-indigo-50 border border-indigo-100 hover:bg-indigo-100 px-4 py-2 rounded-xl transition inline-flex items-center justify-center gap-2" title="Unduh template Excel kosong">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m6.75 12l-3-3m0 0l-3 3m3-3v6m-1.5-13.5h3.75a1.125 1.125 0 011.125 1.125v16.5a1.125 1.125 0 01-1.125 1.125H5.25a1.125 1.125 0 01-1.125-1.125V3.75A1.125 1.125 0 015.25 2.25h3.75" />
            </svg>
            <span class="sm:inline">Template</span>
        </a>

        <a href="{{ route('data-peserta.export') }}" class="text-sm font-medium text-emerald-700 bg-emerald-50 border border-emerald-100 hover:bg-emerald-100 px-4 py-2 rounded-xl transition inline-flex items-center justify-center gap-2">
            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
            <span>Export</span>
        </a>
        
        <div class="hidden sm:block h-6 w-px bg-slate-200 mx-1"></div>

        <a href="{{ route('data-peserta.create') }}" class="flex items-center justify-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-medium shadow-sm transition-all duration-150 whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7-7H5" />
            </svg>
            Tambah Peserta
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-400 text-xs font-semibold uppercase tracking-wider border-b border-slate-100">
                    <th class="px-6 py-4 w-16 text-center">No</th>
                    <th class="px-6 py-4">No. Pendaftaran / NISN</th>
                    <th class="px-6 py-4">Nama Lengkap</th>
                    <th class="px-6 py-4">Jenis Kelamin</th>
                    <th class="px-6 py-4">Desa & Kecamatan</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                @forelse($peserta ?? [] as $item)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-6 py-4 text-center text-slate-400 font-medium">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4">
                        <div class="text-xs font-semibold text-indigo-600 font-mono">{{ $item->nomor_pendaftaran ?? 'Belum Generate' }}</div>
                        <div class="text-xs text-slate-400 font-mono mt-0.5">NISN: {{ $item->nisn ?? '-' }}</div>
                    </td>
                    <td class="px-6 py-4 font-medium text-slate-800">{{ $item->nama_lengkap }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium {{ $item->jenis_kelamin == 'Laki-laki' ? 'bg-blue-50 text-blue-700' : 'bg-pink-50 text-pink-700' }}">
                            {{ $item->jenis_kelamin }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-slate-500">
                        <div class="text-slate-700 font-medium">{{ $item->desa_kelurahan }}</div>
                        <div class="text-xs text-slate-400">Kec. {{ $item->kecamatan }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('data-peserta.detail', $item->id) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition inline-block" title="Lihat Detail Lengkap">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>

                            <a href="{{ route('data-peserta.edit', $item->id) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Ubah Biodata">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                </svg>
                            </a>

                            <form action="{{ route('data-peserta.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berkas pendaftaran {{ $item->nama_lengkap }}?');" class="inline">
                                @csrf
                                @method('DELETE')
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
                    <td colspan="6" class="text-center py-12 text-slate-400">Belum ada data siswa terdaftar.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection