@extends('layouts.dashboard')

@section('title', 'Ubah Dokumen & Verifikasi Registrasi')

@section('content')
<div class="max-w-4xl mx-auto bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-100 bg-slate-50">
        <h3 class="text-lg font-bold text-slate-800">Pembaruan Registrasi & Dokumen Kelulusan</h3>
        <p class="text-xs text-slate-500">Periksa file dokumen terupload lama, ganti file lampiran, atau lakukan aksi perubahan status kelulusan berkas.</p>
    </div>

    <form action="{{ route('registrasi.update', $registrasi->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
        @csrf
        @method('PUT')

        @if($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-100 text-rose-800 rounded-xl text-sm space-y-1">
            <span class="font-bold">Perbaiki Kesalahan Berikut:</span>
            <ul class="list-disc list-inside text-xs">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-slate-600 font-medium mb-1 text-sm">Nama Peserta Didik (Terkunci)</label>
                <input type="text" disabled value="{{ $registrasi->pesertaDidik->nama_lengkap ?? 'Siswa Terhapus' }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-slate-100 text-slate-500 text-sm font-semibold">
                <input type="hidden" name="peserta_didik_id" value="{{ $registrasi->peserta_didik_id }}">
            </div>

            <div>
                <label class="block text-slate-600 font-medium mb-1 text-sm">Kompetensi Keahlian Jurusan *</label>
                <select name="kompetensi_keahlian" required class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white text-sm">
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
                    <option value="{{ $jurusan }}" {{ old('kompetensi_keahlian', $registrasi->kompetensi_keahlian) == $jurusan ? 'selected' : '' }}>
                        {{ $jurusan }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-600 font-medium mb-1 text-sm">Jenis Pendaftaran *</label>
                <select name="jenis_pendaftaran" required class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white text-sm">
                    @foreach(['Siswa Baru', 'Pindahan', 'Kembali Bersekolah'] as $item)
                    <option value="{{ $item }}" {{ old('jenis_pendaftaran', $registrasi->jenis_pendaftaran) == $item ? 'selected' : '' }}>{{ $item }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-slate-600 font-medium mb-1 text-sm">Sekolah Asal</label>
                <input type="text" name="sekolah_asal" value="{{ old('sekolah_asal', $registrasi->sekolah_asal) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm">
            </div>

            <div>
                <label class="block text-slate-600 font-medium mb-1 text-sm">Pernah PAUD? *</label>
                <select name="pernah_paud" required class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white text-sm">
                    <option value="Tidak" {{ old('pernah_paud', $registrasi->pernah_paud) == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                    <option value="Ya" {{ old('pernah_paud', $registrasi->pernah_paud) == 'Ya' ? 'selected' : '' }}>Ya</option>
                </select>
            </div>

            <div>
                <label class="block text-slate-600 font-medium mb-1 text-sm">Hobi</label>
                <input type="text" name="hobi" value="{{ old('hobi', $registrasi->hobi) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm">
            </div>

            <div>
                <label class="block text-slate-600 font-medium mb-1 text-sm">Cita-Cita</label>
                <input type="text" name="cita_cita" value="{{ old('cita_cita', $registrasi->cita_cita) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-sm">
            </div>

            <div>
                <label class="block text-indigo-600 font-bold mb-1 text-sm">Penetapan Status Registrasi Akhir *</label>
                <select name="status_registrasi" required class="w-full px-4 py-2 border border-indigo-300 rounded-xl bg-indigo-50/50 font-semibold text-sm">
                    @foreach(['Menunggu Verifikasi', 'Diterima', 'Ditolak'] as $status)
                    <option value="{{ $status }}" {{ old('status_registrasi', $registrasi->status_registrasi) == $status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="border-t border-slate-100 pt-4">
            <h4 class="text-sm font-bold text-slate-700 mb-4 bg-slate-50 p-2.5 rounded-lg">Manajemen Berkas Lampiran Dokumen</h4>
            <div class="space-y-4 text-xs">
                @foreach([
                'kk' => 'Kartu Keluarga (KK)',
                'ktp_ortu' => 'KTP Orang Tua',
                'akta_kelahiran' => 'Akta Kelahiran',
                'surat_keterangan_lulus' => 'Surat Keterangan Lulus (SKL)',
                'kartu_kesejahteraan' => 'Kartu Kesejahteraan (KKS/KPS)',
                'sptjm' => 'Surat Pernyataan SPTJM',
                'surat_pernyataan_tata_tertib' => 'Surat Pernyataan Tata Tertib Sekolah'
                ] as $fieldName => $labelName)
                <div class="p-3 border border-slate-100 rounded-xl bg-slate-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="w-1/3">
                        <span class="font-semibold text-slate-700 block">{{ $labelName }}</span>
                        @if($registrasi->$fieldName)
                        <a href="{{ asset('storage/' . $registrasi->$fieldName) }}" target="_blank" class="text-indigo-600 hover:underline font-medium inline-flex items-center gap-1 mt-0.5">
                            📄 Lihat File Terupload
                        </a>
                        @else
                        <span class="text-slate-400 italic block mt-0.5">Belum ada file</span>
                        @endif
                    </div>
                    <div class="flex-1">
                        <input type="file" name="{{ $fieldName }}" class="w-full p-1 bg-white border border-slate-200 rounded-lg">
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('registrasi.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition text-sm font-medium">Batal</a>
            <button type="submit" class="px-5 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition font-semibold text-sm">Simpan Perubahan Berkas</button>
        </div>
    </form>
</div>
@endsection