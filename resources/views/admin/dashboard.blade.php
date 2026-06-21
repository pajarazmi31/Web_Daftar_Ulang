@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@section('header_title', 'Dashboard Admin')
@section('header_subtitle', 'Kelola data daftar ulang peserta didik dengan mudah dan cepat.')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

    <div class="bg-white rounded-2xl border border-slate-100 p-6 transition-all duration-200 hover:shadow-md hover:-translate-y-0.5">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-slate-400 text-sm font-medium tracking-wide">Akun Operator</p>
                <h3 class="text-3xl font-bold tracking-tight text-sky-600 mt-2">
                    {{ $totalOperator ?? 0 }}
                </h3>
            </div>
            <div class="p-3 rounded-xl bg-sky-50 text-sky-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 p-6 transition-all duration-200 hover:shadow-md hover:-translate-y-0.5">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-slate-400 text-sm font-medium tracking-wide">Total Peserta Didik</p>
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
                <h3 class="text-3xl font-bold tracking-tight text-emerald-600 mt-2">
                    {{ $registrasiLengkap ?? 0 }}
                </h3>
            </div>
            <div class="p-3 rounded-xl bg-emerald-50 text-emerald-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
    </div>


</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">

    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h3 class="font-semibold text-slate-800 tracking-wide text-base">
                Peserta Didik Terbaru
            </h3>
            <span class="text-xs font-medium text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-md">Live Update</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 text-xs font-semibold uppercase tracking-wider border-b border-slate-100">
                        <th class="px-6 py-3.5 font-medium w-16 text-center">No</th>
                        <th class="px-6 py-3.5 font-medium">NISN</th>
                        <th class="px-6 py-3.5 font-medium">Nama Lengkap</th>
                        <th class="px-6 py-3.5 font-medium">Status Registrasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                    @forelse($pesertaTerbaru ?? [] as $item)
                    <tr class="hover:bg-slate-50/70 transition-colors duration-150">
                        <td class="px-6 py-4 text-center text-slate-400 font-medium">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4 font-mono text-slate-700 tracking-tight">
                            {{ $item->nisn }}
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-800">
                            {{ $item->nama_lengkap }}
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-800">
                            {{ $item->registrasi?->status_registrasi ?? 'Belum Registrasi' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-10 text-slate-400">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m16.5 0a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25m16.5 0V6a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 6v1.5M10.5 11.25h3m-3 3h3" />
                                </svg>
                                <p class="text-sm">Belum ada data pendaftaran terbaru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

<div class="bg-white rounded-2xl border border-slate-100 p-6 flex flex-col justify-between">
    <div>
        <h3 class="font-semibold text-slate-800 tracking-wide text-base mb-4 flex items-center gap-2 border-b border-slate-100 pb-3">
            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span>Informasi Admin</span>
        </h3>

        <div class="flex items-center gap-4 pb-4 mb-4 ">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-lg uppercase shadow-inner">
                {{ substr(auth()->user()->name ?? 'AD', 0, 2) }}
            </div>
            <div class="overflow-hidden">
                <span class="block font-semibold text-slate-700 truncate">{{ auth()->user()->name ?? 'Administrator' }}</span>
            </div>
        </div>

        <div class="space-y-4">
            <div>
                <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Alamat Email</span>
                <span class="text-sm font-medium text-slate-600 block truncate">{{ auth()->user()->email ?? 'admin@sekolah.sch.id' }}</span>
            </div>

            <div>
                <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-0.5">Waktu Aktivitas</span>
                <span class="text-sm font-medium text-slate-600 flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ now()->translatedFormat('H:i') }} WIB, {{ now()->translatedFormat('d M Y') }}</span>
                </span>
            </div>
        </div>
    </div>

    <div class="mt-6 pt-4 border-t border-slate-100">
        <span class="block text-[11px] font-bold text-amber-500 uppercase tracking-wider mb-1.5 flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <span>Catatan Keamanan</span>
        </span>
        <p class="text-xs text-slate-400 leading-relaxed font-medium">
            Akun ini memiliki hak akses penuh terhadap konfigurasi sistem dan manajemen pengguna. Pastikan untuk selalu logout setelah selesai menggunakannya dari perangkat mana pun.
        </p>
    </div>
</div>

</div>
@endsection