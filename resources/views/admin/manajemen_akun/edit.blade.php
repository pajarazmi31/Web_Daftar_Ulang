@extends('layouts.dashboard')

@section('title', 'Ubah Data Akun')

@section('header_title', 'Ubah Akun')
@section('header_subtitle', 'Perbarui informasi profil pengguna atau perbarui hak akses.')

@section('content')
<div class="max-w-2xl bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
    <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
        <h3 class="font-semibold text-slate-800 text-base">Form Sunting Akun: {{ $user->name }}</h3>
        <a href="{{ route('manajemen_akun') }}" class="text-xs text-slate-400 hover:text-indigo-600 transition flex items-center gap-1">
            &larr; Kembali
        </a>
    </div>
    
    <form action="{{ route('manajemen_akun.update', $user->id) }}" method="POST" class="p-6 space-y-5 text-sm">
        @csrf
        @method('PUT')
        
        <div>
            <label class="block text-slate-600 font-medium mb-1.5">Nama Lengkap Pengguna</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 border @error('name') border-rose-400 focus:border-rose-500 @else border-slate-200 focus:border-indigo-500 @enderror rounded-xl focus:outline-none transition">
            @error('name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-slate-600 font-medium mb-1.5">Alamat Email Resmi</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2.5 border @error('email') border-rose-400 focus:border-rose-500 @else border-slate-200 focus:border-indigo-500 @enderror rounded-xl focus:outline-none transition">
            @error('email') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-slate-600 font-medium mb-1.5">Hak Akses / Jabatan Sistem</label>
            <select name="role_id" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl bg-white focus:outline-none focus:border-indigo-500 transition">
                @foreach($roles ?? [] as $role)
                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                        {{ strtoupper($role->nama_role) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="p-4 bg-amber-50/60 rounded-xl border border-amber-100 text-xs text-amber-700 leading-relaxed">
            <strong>Catatan Keamanan:</strong> Kosongkan kolom kata sandi di bawah ini jika tidak ingin merubah password pengguna saat ini.
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-slate-600 font-medium mb-1.5">Kata Sandi Baru (Opsional)</label>
                <input type="password" name="password" placeholder="Isi jika ganti" class="w-full px-4 py-2.5 border @error('password') border-rose-400 focus:border-rose-500 @else border-slate-200 focus:border-indigo-500 @enderror rounded-xl focus:outline-none transition">
                @error('password') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-slate-600 font-medium mb-1.5">Konfirmasi Kata Sandi Baru</label>
                <input type="password" name="password_confirmation" placeholder="Ulangi kata sandi baru" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 transition">
            </div>
        </div>

        <div class="pt-4 border-t border-slate-100 flex justify-end gap-3">
            <a href="{{ route('manajemen_akun') }}" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-medium transition text-center">
                Batal
            </a>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-medium shadow-sm transition">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection