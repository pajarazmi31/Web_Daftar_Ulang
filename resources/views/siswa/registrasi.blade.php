@extends('layouts.dashboard')

@section('title', 'Registrasi Mandiri')
@section('header_title', 'Registrasi Mandiri Peserta Didik')
@section('header_subtitle', 'Lengkapi data kompetensi keahlian beserta upload berkas scan lampiran pendaftaran fisik resmi.')

@section('content')
<div class="max-w-4xl mx-auto">
@if($sudahRegistrasi)
    <div class="flex flex-col items-center justify-center min-h-[calc(100vh-160px)] w-full p-4 md:p-8 animate-fade-in bg-slate-50/50">

        <div class="bg-white p-6 md:p-10 rounded-2xl border border-slate-100 shadow-xl max-w-2xl w-full text-center">
            <div class="flex flex-col items-center gap-6">

                <div class="p-4 bg-emerald-50 rounded-full text-emerald-500 animate-bounce-short">
                    <svg class="w-16 h-16 md:w-20 md:h-20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <div class="space-y-2">
                    <h3 class="font-bold text-2xl md:text-3xl text-slate-800">Registrasi Anda Sudah Kami Terima!</h3>
                    <p class="text-sm md:text-base text-slate-500 max-w-2xl mx-auto">
                        Sistem mendeteksi bahwa Anda telah melakukan registrasi sebelumnya. Data Anda aman dan sedang dalam antrean verifikasi.
                    </p>
                </div>

                <div class="w-full bg-amber-50/60 border border-amber-100 rounded-xl p-4 text-left flex gap-3 items-start">
                    <svg class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <div class="text-xs md:text-sm text-amber-800 space-y-1">
                        <p class="font-semibold">Berapa lama proses ini?</p>
                        <p class="text-amber-700/90 leading-relaxed">
                            Proses verifikasi berkas umumnya memakan waktu **1-3 hari kerja**. Hasil kelulusan atau instruksi lanjutan akan diinformasikan lebih lanjut.
                        </p>
                    </div>
                </div>

            </div>
        </div>

    </div>
    @else
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 bg-slate-50">
            <h3 class="text-lg font-bold text-slate-800">Formulir Registrasi Masuk & Berkas</h3>
            <p class="text-xs text-slate-500">Silakan isi formulir di bawah dengan benar dan lampirkan berkas yang diperlukan.</p>
        </div>

        <form action="{{ route('registrasi.siswa.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            @if ($errors->any())
            <div class="bg-red-50 text-red-800 p-4 rounded-xl border border-red-200 text-sm">
                <span class="font-bold block mb-1">⚠️ Gagal menyimpan data, periksa kendala berikut:</span>
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- DATA INPUT UTAMA JURUSAN & SEKOLAH --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">1. Kompetensi Keahlian Jurusan *</label>
                    <select name="kompetensi_keahlian" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:border-indigo-500 transition">
                        <option value="">-- Pilih Kompetensi Keahlian --</option>
                        @foreach([
                        'Teknik Otomotif',
                        'Teknik Jaringan Komputer dan Telekomunikasi',
                        'Pengembangan Perangkat Lunak dan Gim',
                        'Desain Pemodelan dan Informasi Bangunan',
                        'Manajemen Perkantoran dan Layanan Bisnis',
                        'Akuntansi dan Keuangan Lembaga',
                        'Seni Pertunjukan'
                        ] as $jurusan)
                        <option value="{{ $jurusan }}" {{ old('kompetensi_keahlian') == $jurusan ? 'selected' : '' }}>
                            {{ $jurusan }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-slate-600 font-medium mb-1">2. Jalur Pendaftaran *</label>
                    <select name="jalur_pendaftaran" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:border-indigo-500 transition">
                        <option value="">-- Pilih Jalur --</option>
                        <option value="Zonasi" {{ old('jalur_pendaftaran') == 'Zonasi' ? 'selected' : '' }}>Zonasi</option>
                        <option value="Afirmasi" {{ old('jalur_pendaftaran') == 'Afirmasi' ? 'selected' : '' }}>Afirmasi</option>
                        <option value="Prestasi" {{ old('jalur_pendaftaran') == 'Prestasi' ? 'selected' : '' }}>Prestasi</option>
                    </select>
                </div>

                <div>
                    <label class="block text-slate-600 font-medium mb-1">3. Jenis Pendaftaran *</label>
                    <select name="jenis_pendaftaran" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:border-indigo-500 transition">
                        @foreach(['Siswa Baru', 'Pindahan', 'Kembali Bersekolah'] as $item)
                        <option value="{{ $item }}" {{ old('jenis_pendaftaran') == $item ? 'selected' : '' }}>{{ $item }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-slate-600 font-medium mb-1">4. Sekolah Asal</label>
                    <input type="text" name="sekolah_asal" value="{{ old('sekolah_asal') }}" placeholder="Contoh: SMP Negeri 1 Kawali" class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 transition">
                </div>

                <div>
                    <label class="block text-slate-600 font-medium mb-1">5. Pernah PAUD? *</label>
                    <select name="pernah_paud" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:border-indigo-500 transition">
                        <option value="Tidak" {{ old('pernah_paud') == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                        <option value="Ya" {{ old('pernah_paud') == 'Ya' ? 'selected' : '' }}>Ya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-slate-600 font-medium mb-1">6. Hobi</label>
                    <input type="text" name="hobi" value="{{ old('hobi') }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 transition">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-slate-600 font-medium mb-1">7. Cita-Cita</label>
                    <input type="text" name="cita_cita" value="{{ old('cita_cita') }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 transition">
                </div>
            </div>

            {{-- DATA UPLOAD BERKAS LAMPIRAN --}}
            <div class="border-t border-slate-100 pt-4">
                <h4 class="text-sm font-bold text-slate-700 mb-4 bg-slate-50 p-2.5 rounded-lg">Upload Lampiran Dokumen Scan Fisik (Format: PDF/JPG/PNG, Max: 2MB)</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                    <div>
                        <label class="block text-slate-600 font-medium mb-1">Upload Kartu Keluarga (KK) *</label>
                        <input type="file" name="kk" class="w-full p-1.5 border border-slate-200 rounded-lg bg-white">
                    </div>
                    <div>
                        <label class="block text-slate-600 font-medium mb-1">Upload KTP Orang Tua *</label>
                        <input type="file" name="ktp_ortu" class="w-full p-1.5 border border-slate-200 rounded-lg bg-white">
                    </div>
                    <div>
                        <label class="block text-slate-600 font-medium mb-1">Upload Akta Kelahiran *</label>
                        <input type="file" name="akta_kelahiran" class="w-full p-1.5 border border-slate-200 rounded-lg bg-white">
                    </div>
                    <div>
                        <label class="block text-slate-600 font-medium mb-1">Upload Surat Keterangan Lulus (SKL) *</label>
                        <input type="file" name="surat_keterangan_lulus" class="w-full p-1.5 border border-slate-200 rounded-lg bg-white">
                    </div>
                    <div>
                        <label class="block text-slate-600 font-medium mb-1">Upload Kartu Kesejahteraan (KKS/KPS jika ada)</label>
                        <input type="file" name="kartu_kesejahteraan" class="w-full p-1.5 border border-slate-200 rounded-lg bg-white">
                    </div>
                    <div>
                        <label class="block text-slate-600 font-medium mb-1">Upload SPTJM Berkas *</label>
                        <input type="file" name="sptjm" class="w-full p-1.5 border border-slate-200 rounded-lg bg-white">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-slate-600 font-medium mb-1">Upload Surat Pernyataan Tata Tertib Sekolah *</label>
                        <input type="file" name="surat_pernyataan_tata_tertib" class="w-full p-1.5 border border-slate-200 rounded-lg bg-white">
                    </div>
                </div>
            </div>

            {{-- BUTTON ACTIONS --}}
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="submit" class="px-6 py-2.5 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 shadow-md shadow-emerald-600/10 transition font-semibold text-sm">
                    Kirim Pendaftaran & Berkas
                </button>
            </div>
        </form>
    </div>
    @endif
</div>
@endsection