@extends('layouts.dashboard')

@section('title', 'Tambah Akun Baru')

@section('header_title', 'Tambah Akun')
@section('header_subtitle', 'Buat hak akses baru untuk operator atau pimpinan.')

@section('content')
<div class="max-w-3xl bg-white rounded-2xl border border-slate-100 p-6 sm:p-8 shadow-sm">
    
    <div class="mb-8 flex justify-between items-baseline">
        <div>
            <h3 class="font-bold text-slate-900 text-lg tracking-tight">Form Pengguna Baru</h3>
            <p class="text-xs text-slate-400 mt-0.5">Lengkapi detail akun pendaftaran.</p>
        </div>
        <a href="{{ route('manajemen_akun') }}" class="text-xs font-medium text-slate-400 hover:text-slate-600 transition flex items-center gap-1.5">
            &larr; Kembali
        </a>
    </div>
    
    <form action="{{ route('manajemen_akun.store') }}" method="POST" class="space-y-6 text-sm">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div class="space-y-1.5">
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Lengkap Pengguna</label>
            <input type="text" name="name" value="{{ old('name') }}" required 
                   placeholder="Contoh: Andi Wijaya" 
                   class="w-full px-4 py-2.5 bg-slate-50/50 border @error('name') border-rose-300 focus:ring-rose-100 @else border-slate-200 focus:border-slate-400 focus:ring-slate-100 @enderror rounded-xl focus:outline-none focus:ring-2 transition placeholder:text-slate-300 font-medium text-slate-800">
            @error('name') <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="space-y-1.5">
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Alamat Email Resmi</label>
            <input type="email" name="email" value="{{ old('email') }}" required 
                   placeholder="contoh@sekolah.sch.id" 
                   class="w-full px-4 py-2.5 bg-slate-50/50 border @error('email') border-rose-300 focus:ring-rose-100 @else border-slate-200 focus:border-slate-400 focus:ring-slate-100 @enderror rounded-xl focus:outline-none focus:ring-2 transition placeholder:text-slate-300 font-medium text-slate-800">
            @error('email') <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p> @enderror
        </div>
        </div>
        <div class="space-y-1.5">
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Hak Akses / Jabatan Sistem</label>
            <div class="relative">
                <select name="role_id" required 
                        class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-100 rounded-xl focus:outline-none transition appearance-none font-semibold text-slate-700">
                    @foreach($roles ?? [] as $role)
                        <option value="{{ $role->id }}">{{ strtoupper($role->nama_role) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Kata Sandi (Password)</label>
                <input type="password" name="password" required 
                       placeholder="Minimal 8 karakter" 
                       class="w-full px-4 py-2.5 bg-slate-50/50 border @error('password') border-rose-300 focus:ring-rose-100 @else border-slate-200 focus:border-slate-400 focus:ring-slate-100 @enderror rounded-xl focus:outline-none focus:ring-2 transition placeholder:text-slate-300 font-medium text-slate-800">
                @error('password') <p class="text-xs text-rose-500 font-medium mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" required 
                       placeholder="Ulangi kata sandi" 
                       class="w-full px-4 py-2.5 bg-slate-50/50 border border-slate-200 focus:border-slate-400 focus:ring-2 focus:ring-slate-100 rounded-xl focus:outline-none transition placeholder:text-slate-300 font-medium text-slate-800">
            </div>
        </div>

        <div class="pt-4 flex justify-end items-center gap-4">
            <a href="{{ route('manajemen_akun') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600 transition tracking-wider uppercase">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-400 font-semibold text-white text-xs tracking-wider uppercase shadow-sm hover:shadow transition">
                Simpan Akun
            </button>
        </div>
    </form>
</div>
@endsection