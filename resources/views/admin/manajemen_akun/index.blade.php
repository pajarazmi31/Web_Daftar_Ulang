@extends('layouts.dashboard')

@section('title', 'Manajemen Akun')

@section('header_title', 'Manajemen Akun')
@section('header_subtitle', 'Kelola hak akses dan akun operator atau pimpinan.')

@section('content')
<div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-slate-100">
    <div class="p-6 flex flex-col gap-4 bg-slate-50/50 border-b border-slate-100">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
<form action="{{ url()->current() }}" method="GET" class="relative flex-1 max-w-md flex items-center">
    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </span>
    
    <input
        type="text"
        name="search"
        value="{{ request('search') }}"
        placeholder="Cari nama atau NISN..."
        class="w-full pl-10 pr-24 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 focus:bg-white transition-all text-slate-700">
    
    <div class="absolute inset-y-0 right-0 flex items-center pr-4 gap-2">
        @if(request('search'))
            <a href="{{ url()->current() }}" class="text-xs text-slate-400 hover:text-slate-600 font-medium transition-colors px-1">
                Reset
            </a>
            <span class="h-4 w-px bg-slate-200"></span>
        @endif
        <button class="text-xs text-slate-400 hover:text-slate-600 font-medium transition-colors">Cari</button>
    </div>
</form>
            <a href="{{ route('manajemen_akun.create') }}" class="flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-medium shadow-sm transition-all duration-150 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7-7H5" />
                </svg>
                Tambah Akun Baru
            </a>
        </div>

    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-400 text-xs font-semibold uppercase tracking-wider border-b border-slate-100">
                    <th class="px-6 py-4 w-16 text-center">No</th>
                    <th class="px-6 py-4">Nama Pengguna</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Hak Akses / Role</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                @forelse($users ?? [] as $user)
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="px-6 py-4 text-center text-slate-400 font-medium">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 font-medium text-slate-800">{{ $user->name }}</td>
                    <td class="px-6 py-4 text-slate-500 font-medium">{{ $user->email }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium uppercase tracking-wider {{ $user->role->nama_role == 'admin' ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'bg-slate-100 text-slate-700' }}">
                            {{ $user->role->nama_role }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('manajemen_akun.edit', $user->id) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Ubah Akun">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                </svg>
                            </a>

                            <form action="{{ route('manajemen_akun.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun {{ $user->name }}? Tindakan ini tidak dapat dibatalkan.');" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus Akun">
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
                    <td colspan="5" class="text-center py-10 text-slate-400">
                        @if(request('search'))
                        Tidak ada data pengguna yang cocok dengan "{{ request('search') }}".
                        @else
                        Tidak ada data pengguna.
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
            @if($users->hasPages())
        <div class="px-6 py-4 bg-white border-t border-slate-100 flex items-center justify-between">
            <div class="text-xs text-slate-500">
                Menampilkan <span class="font-medium text-slate-800">{{ $users->firstItem() }}</span> 
                sampai <span class="font-medium text-slate-800">{{ $users->lastItem() }}</span> 
                dari <span class="font-medium text-slate-800">{{ $users->total() }}</span> peserta
            </div>

            <div class="flex items-center gap-2">
                {{-- Tombol Previous --}}
                @if ($users->onFirstPage())
                    <span class="cursor-not-allowed opacity-40 inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-slate-400 bg-slate-50 border border-slate-200 rounded-lg select-none">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                        Sebelumnya
                    </span>
                @else
                    <a href="{{ $users->previousPageUrl() }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 border border-indigo-100 rounded-lg transition-colors duration-150">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                        Sebelumnya
                    </a>
                @endif

                {{-- Status Halaman Aktif (Contoh: 1 / 12) --}}
                <span class="text-xs font-medium text-slate-600 px-2">
                    {{ $users->currentPage() }} <span class="text-slate-300">/</span> {{ $users->lastPage() }}
                </span>

                {{-- Tombol Next --}}
                @if ($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 border border-indigo-100 rounded-lg transition-colors duration-150">
                        Selanjutnya
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                    </a>
                @endif
            </div>
        </div>
        @endif
</div>
@endsection