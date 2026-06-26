@extends('layouts.dashboard')

@section('title', 'Tambah Dokumen Registrasi')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-100 bg-slate-50">
        <h3 class="text-lg font-bold text-slate-800">Formulir Registrasi Masuk & Berkas</h3>
        <p class="text-xs text-slate-500">Lengkapi data kompetensi keahlian beserta upload berkas scan lampiran pendaftaran fisik resmi.</p>
    </div>

    <form action="{{ route('registrasi.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
        @csrf

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-slate-600 font-medium mb-1 text-sm">1. Pilih Peserta Didik *</label>
                <select name="peserta_didik_id" required class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white text-sm">
                    <option value="">-- Pilih Calon Siswa --</option>
                    @foreach($pesertaList as $p)
                    <option value="{{ $p->id }}" {{ old('peserta_didik_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap }} (NIK: {{ $p->nik }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-600 font-medium mb-1 text-sm">3. Jenis Pendaftaran *</label>
                <select name="jenis_pendaftaran" required class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white text-sm">
                    @foreach(['Siswa Baru', 'Pindahan', 'Kembali Bersekolah'] as $item)
                    <option value="{{ $item }}" {{ old('jenis_pendaftaran') == $item ? 'selected' : '' }}>{{ $item }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-600 font-medium mb-1 text-sm">4. Sekolah Asal</label>
                <input type="text" name="sekolah_asal" value="{{ old('sekolah_asal') }}" placeholder="Contoh: SMP Negeri 1 Kawali" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm">
            </div>

            <div>
                <label class="block text-slate-600 font-medium mb-1 text-sm">5. Pernah PAUD? *</label>
                <select name="pernah_paud" required class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white text-sm">
                    <option value="Tidak" {{ old('pernah_paud') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    <option value="Ya" {{ old('pernah_paud') == 'Ya' ? 'selected' : '' }}>Ya</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-600 font-medium mb-1 text-sm">6. Hobi</label>
                <input type="text" name="hobi" value="{{ old('hobi') }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm">
            </div>

            <div>
                <label class="block text-slate-600 font-medium mb-1 text-sm">7. Cita-Cita</label>
                <input type="text" name="cita_cita" value="{{ old('cita_cita') }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm">
            </div>

            <div>
                <label class="block text-slate-600 font-medium mb-1 text-sm">8. Status Verifikasi Awal *</label>
                <select name="status_registrasi" required class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white text-sm">
                    <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                    <option value="Diterima">Diterima</option>
                    <option value="Ditolak">Ditolak</option>
                </select>
            </div>
        </div>

        <div class="border-t border-slate-100 pt-4">
            <h4 class="text-sm font-bold text-slate-700 mb-4 bg-slate-50 p-2.5 rounded-lg">Upload Lampiran Dokumen Scan Fisik (Format: PDF/JPG/PNG, Max: 2MB)</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">Upload Kartu Keluarga (KK)</label>
                    <input type="file" name="kk" class="w-full p-1.5 border border-slate-200 rounded-lg">
                    @error('kk')
                    <p class="text-rose-500 text-xs mt-1">
                        Ukuran file Anda terlalu besar (maksimal 2MB) atau format tidak sesuai.
                    </p>
                    @enderror
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">Upload KTP Orang Tua</label>
                    <input type="file" name="ktp_ortu" class="w-full p-1.5 border border-slate-200 rounded-lg">
                    @error('ktp_ortu')
                    <p class="text-rose-500 text-xs mt-1">
                        Ukuran file Anda terlalu besar (maksimal 2MB) atau format tidak sesuai.
                    </p>
                    @enderror
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">Upload Akta Kelahiran</label>
                    <input type="file" name="akta_kelahiran" class="w-full p-1.5 border border-slate-200 rounded-lg">
                    @error('akta_kelahiran')
                    <p class="text-rose-500 text-xs mt-1">
                        Ukuran file Anda terlalu besar (maksimal 2MB) atau format tidak sesuai.
                    </p>
                    @enderror
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">Upload Surat Keterangan Lulus (SKL)</label>
                    <input type="file" name="surat_keterangan_lulus" class="w-full p-1.5 border border-slate-200 rounded-lg">
                    @error('surat_keterangan_lulus')
                    <p class="text-rose-500 text-xs mt-1">
                        Ukuran file Anda terlalu besar (maksimal 2MB) atau format tidak sesuai.
                    </p>
                    @enderror
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">Upload Kartu Kesejahteraan (KKS/KPS jika ada)</label>
                    <input type="file" name="kartu_kesejahteraan" class="w-full p-1.5 border border-slate-200 rounded-lg">
                    @error('kartu_kesejahteraan')
                    <p class="text-rose-500 text-xs mt-1">
                        Ukuran file Anda terlalu besar (maksimal 2MB) atau format tidak sesuai.
                    </p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('registrasi.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition text-sm font-medium">Batal</a>
            <button type="submit" class="px-5 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition font-semibold text-sm">Simpan Berkas Registrasi</button>
        </div>
    </form>
</div>
@endsection