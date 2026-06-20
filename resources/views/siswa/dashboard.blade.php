@extends('layouts.dashboard')

@section('title', 'Dashboard Siswa')
@section('header_title', 'Selamat Datang, ' . auth()->user()->name)
@section('header_subtitle', 'Pusat informasi dan registrasi mandiri peserta didik.')

@section('content')
<div class="space-y-6">

    <div>
        @if($sudahRegistrasi)
            @if($statusRegistrasi == 'disetujui')
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-900 text-sm flex items-start gap-3 shadow-sm">
                    <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-md shadow-emerald-500/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-emerald-900">Registrasi Disetujui!</h4>
                        <p class="text-emerald-700/90 text-xs mt-0.5">Selamat, proses registrasi Anda telah diverifikasi oleh operator. Silakan periksa kembali data diri Anda.</p>
                    </div>
                </div>
            @elseif($statusRegistrasi == 'ditolak')
                <div class="p-4 rounded-2xl bg-rose-50 border border-rose-100 text-rose-900 text-sm flex items-start gap-3 shadow-sm">
                    <div class="w-8 h-8 rounded-xl bg-rose-500 text-white flex items-center justify-center shrink-0 shadow-md shadow-rose-500/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-rose-900">Registrasi Memerlukan Perbaikan</h4>
                        <p class="text-rose-700/90 text-xs mt-0.5">Mohon maaf, terdapat data yang belum sesuai. Silakan edit kembali data diri Anda atau hubungi panitia.</p>
                    </div>
                </div>
            @else
                <div class="p-4 rounded-2xl bg-amber-50 border border-amber-100 text-amber-900 text-sm flex items-start gap-3 shadow-sm">
                    <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0 shadow-md shadow-amber-500/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-amber-900">Menunggu Verifikasi</h4>
                        <p class="text-amber-700/90 text-xs mt-0.5">Registrasi mandiri Anda telah diterima. Saat ini berkas Anda sedang dalam proses peninjauan oleh operator.</p>
                    </div>
                </div>
            @endif
        @else
            <div class="p-4 rounded-2xl bg-indigo-50 border border-indigo-100 text-indigo-900 text-sm flex items-start gap-3 shadow-sm">
                <div class="w-8 h-8 rounded-xl bg-indigo-500 text-white flex items-center justify-center shrink-0 shadow-md shadow-indigo-500/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div class="flex-1 sm:flex sm:items-center sm:justify-between gap-4">
                    <div>
                        <h4 class="font-bold text-indigo-900">Anda Belum Mengisi Registrasi</h4>
                        <p class="text-indigo-700/90 text-xs mt-0.5">Segera lengkapi formulir pendaftaran mandiri agar data Anda dapat diproses oleh sekolah.</p>
                    </div>
                    <a href="{{ route('registrasi.siswa') }}" class="inline-block mt-3 sm:mt-0 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl transition shrink-0 text-center">
                        Mulai Registrasi
                    </a>
                </div>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-slate-800">Profil Peserta Didik</h3>
                        <p class="text-slate-400 text-xs">Informasi identitas yang terdaftar</p>
                    </div>
                </div>

                <div class="space-y-2.5 border-t border-slate-50 pt-4">
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-400 font-medium">Nama Lengkap</span>
                        <span class="font-semibold text-slate-700">{{ $peserta->nama_lengkap ?? 'Belum Melakukan Registrasi' }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-400 font-medium">NISN</span>
                        <span class="font-semibold text-slate-700">{{ $peserta->nisn ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-400 font-medium">Email Akun</span>
                        <span class="font-semibold text-slate-700">{{ auth()->user()->email }}</span>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-slate-50 mt-4">
                <a href="{{ route('siswa.data-diri.index') }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-50 hover:bg-slate-100/80 text-slate-700 text-xs font-semibold rounded-xl transition border border-slate-100">
                    <span>Lihat & Edit Detail Data</span>
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-slate-800">Alur & Bantuan</h3>
                        <p class="text-slate-400 text-xs">Langkah pendaftaran aplikasi</p>
                    </div>
                </div>

                <div class="space-y-3 pt-2 text-xs text-slate-600">
                    <div class="flex gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-[10px] shrink-0">1</span>
                        <p>Isi data registrasi mandiri secara lengkap dan benar.</p>
                    </div>
                    <div class="flex gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-[10px] shrink-0">2</span>
                        <p>Tunggu tim verifikator (Operator/Admin) mengecek berkas Anda.</p>
                    </div>
                    <div class="flex gap-2.5">
                        <span class="w-5 h-5 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center font-bold text-[10px] shrink-0">3</span>
                        <p>Jika ada kesalahan, data dapat diubah kembali selama status belum dikunci.</p>
                    </div>
                </div>
            </div>

            <div class="pt-4 text-[11px] text-slate-400 italic">
                * Jika mengalami kendala teknis sistem pendaftaran, silakan hubungi ruang sekretariat panitia.
            </div>
        </div>

    </div>

</div>
@endsection