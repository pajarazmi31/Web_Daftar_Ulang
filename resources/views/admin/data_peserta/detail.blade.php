@extends('layouts.dashboard')

@section('title', 'Detail Calon Peserta Didik')
@section('header_title', 'Profil Lengkap Peserta Didik')
@section('header_subtitle', 'Salinan digital rekam berkas biodata pendaftaran siswa sesuai dokumen asli Dapodik.')

@section('content')
<div class="max-w-5xl mx-auto" x-data="{ activeTab: 'pribadi' }">

    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-lg">
                {{ strtoupper(substr($peserta->nama_lengkap, 0, 1)) }}
            </div>
            <div>
                <h3 class="font-bold text-lg text-slate-900 leading-tight">{{ $peserta->nama_lengkap }}</h3>
                <p class="text-xs text-slate-400 font-medium mt-1">
                    NISN: <span class="text-slate-700 font-mono font-semibold">{{ $peserta->nisn }}</span>
                </p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('data-peserta.index') }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl text-sm font-medium hover:bg-slate-50 transition shadow-sm">
                Kembali
            </a>
            <a href="{{ route('data-peserta.edit', $peserta->id) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-sm font-medium hover:bg-indigo-700 transition shadow-sm flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                </svg>
                Ubah Profil
            </a>
        </div>
    </div>

    <div class="flex border-b border-slate-200 overflow-x-auto mb-6 bg-white rounded-xl p-1.5 shadow-sm w-full whitespace-nowrap scrollbar-none">
        <button type="button" @click="activeTab = 'pribadi'"
            :class="activeTab === 'pribadi' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-50'"
            class="flex-1 shrink-0 text-center py-2.5 px-4 rounded-lg text-xs font-semibold uppercase tracking-wider transition-all duration-150">
            1. Data Pribadi
        </button>
        <button type="button" @click="activeTab = 'periodik'"
            :class="activeTab === 'periodik' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-50'"
            class="flex-1 shrink-0 text-center py-2.5 px-4 rounded-lg text-xs font-semibold uppercase tracking-wider transition-all duration-150">
            2. Periodik & Beasiswa
        </button>
        <button type="button" @click="activeTab = 'ortu'"
            :class="activeTab === 'ortu' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-50'"
            class="flex-1 shrink-0 text-center py-2.5 px-4 rounded-lg text-xs font-semibold uppercase tracking-wider transition-all duration-150">
            3. Orang Tua & Wali
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-6">

        <div x-show="activeTab === 'pribadi'" class="space-y-6">
            <div>
                <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider border-b border-slate-100 pb-2">Identitas Dasar Siswa</h4>
                <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-4 gap-4 text-sm mt-3">
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Nama Lengkap</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->nama_lengkap }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Jenis Kelamin</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->jenis_kelamin }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">NISN</span>
                        <span class="font-semibold text-slate-800 font-mono">{{ $peserta->nisn }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">NIK / No. Identitas</span>
                        <span class="font-semibold text-slate-800 font-mono">{{ $peserta->nik }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">No. KK</span>
                        <span class="font-semibold text-slate-800 font-mono">{{ $peserta->no_kk }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">No. Registrasi Akta</span>
                        <span class="font-semibold text-slate-800 font-mono">{{ $peserta->no_registrasi_akta }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Kompetensi Keahlian Jurusan</span>
                        <span class="text-sm font-semibold text-slate-700">{{ $peserta->kompetensi_keahlian ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Jalur Pendaftaran</span>
                        <span class="text-sm font-semibold text-slate-700">{{ $peserta->jalur_pendaftaran }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Tempat, Tanggal Lahir</span>
                        <span class="font-semibold text-slate-800">
                            {{ $peserta->tempat_lahir }}, {{ \Carbon\Carbon::parse($peserta->tanggal_lahir)->translatedFormat('d F Y') }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Agama</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->agama }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Kewarganegaraan</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->kewarganegaraan }} {{ $peserta->nama_negara ? '('.$peserta->nama_negara.')' : '' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Kebutuhan Khusus</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->kebutuhan_khusus ?? 'Tidak Ada' }}</span>
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider border-b border-slate-100 pb-2">Alamat Tempat Tinggal</h4>
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-4 text-sm mt-3">
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Alamat Jalan</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->alamat ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">RT / RW</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->rt ?? '0' }} / {{ $peserta->rw ?? '0' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Dusun / Kelurahan</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->dusun ?? '-' }} / {{ $peserta->desa_kelurahan ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Kecamatan / Kode Pos</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->kecamatan }} / {{ $peserta->kode_pos ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Kabupaten / Provinsi</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->kabupaten }} / {{ $peserta->provinsi ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Tempat Tinggal</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->tempat_tinggal ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Moda Transportasi</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->moda_transportasi ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="activeTab === 'periodik'" class="space-y-6">
            <div>
                <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider border-b border-slate-100 pb-2">Data Fisik Berkala</h4>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm mt-3">
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Tinggi Badan</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->tinggi_badan ?? '-' }} cm</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Berat Badan</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->berat_badan ?? '-' }} kg</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Jml. Saudara Kandung</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->jumlah_saudara ?? '0' }} orang</span>
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider border-b border-slate-100 pb-2">Jarak & Waktu Tempuh Ke Sekolah</h4>
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-4 text-sm mt-3">
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Kategori Jarak</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->jarak_sekolah ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Detail Jarak (Km)</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->jarak_kilometer ?? '0' }} km</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Waktu Tempuh Ke Sekolah</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->waktu_tempuh ?? '0' }} Menit</span>
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider border-b border-slate-100 pb-2">Kartu Kesejahteraan & Jaminan Sosial</h4>
                <div class="grid grid-cols-2 sm:grid-cols-2 gap-4 text-sm mt-3">
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Penerima KPS / KIP / PKH</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->jenis_kesejahteraan ?? 'Tidak' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Nomor Kartu KPS / KIP</span>
                        <span class="font-semibold text-slate-800 font-mono">{{ $peserta->nomor_kartu_kesejahteraan ?? 'Tidak Ada' }}</span>
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider border-b border-slate-100 pb-2">Informasi Kepemilikan Beasiswa</h4>
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4 text-sm mt-3">
                    <div class="sm:col-span-2">
                        <span class="block text-xs font-medium text-slate-400">Jenis Beasiswa</span>
                        <span class="font-semibold text-slate-600 text-base">{{ $peserta->jenis_beasiswa ?? 'Tidak Mengajukan / Tidak Ada' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Tahun Mulai</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->tahun_mulai_beasiswa ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Tahun Selesai</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->tahun_selesai_beasiswa ?? '-' }}</span>
                    </div>
                    <div class="sm:col-span-4">
                        <span class="block text-xs font-medium text-slate-400">Keterangan Tambahan Beasiswa</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->keterangan_beasiswa ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="activeTab === 'ortu'" class="space-y-6">
            <div>
                <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider border-b border-slate-100 pb-2">Data Ayah Kandung</h4>
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4 text-sm mt-3">
                    <div class="sm:col-span-2">
                        <span class="block text-xs font-medium text-slate-400">Nama Lengkap Ayah</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->nama_ayah }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">NIK Ayah</span>
                        <span class="font-semibold text-slate-800 font-mono">{{ $peserta->nik_ayah ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Tahun Lahir</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->tahun_lahir_ayah ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Pendidikan</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->pendidikan_ayah ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Pekerjaan</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->pekerjaan_ayah ?? '-' }}</span>
                    </div>
                    <div class="sm:col-span-2">
                        <span class="block text-xs font-medium text-slate-400">Penghasilan Bulanan</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->penghasilan_ayah ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider border-b border-slate-100 pb-2">Data Ibu Kandung</h4>
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4 text-sm mt-3">
                    <div class="sm:col-span-2">
                        <span class="block text-xs font-medium text-slate-400">Nama Lengkap Ibu</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->nama_ibu }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">NIK Ibu</span>
                        <span class="font-semibold text-slate-800 font-mono">{{ $peserta->nik_ibu ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Tahun Lahir</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->tahun_lahir_ibu ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Pendidikan</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->pendidikan_ibu ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Pekerjaan</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->pekerjaan_ibu ?? '-' }}</span>
                    </div>
                    <div class="sm:col-span-2">
                        <span class="block text-xs font-medium text-slate-400">Penghasilan Bulanan</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->penghasilan_ibu ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider border-b border-slate-100 pb-2">Data Wali (Jika Ada)</h4>
                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-4 text-sm mt-3">
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Nama Lengkap Wali</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->nama_wali ?? 'Tidak Menggunakan Wali' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Pekerjaan Wali</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->pekerjaan_wali ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Tahun Lahir Wali</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->tahun_lahir_wali ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="pt-2">
                <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider border-b border-slate-100 pb-2">Kontak & Log Sistem</h4>
                <div class="grid grid-cols-2 sm:grid-cols-2 gap-4 text-sm mt-3">
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Nomor HP / WhatsApp</span>
                        <span class="font-semibold text-slate-800 text-indigo-600 font-mono text-base">{{ $peserta->no_hp ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Email Aktif</span>
                        <span class="font-semibold text-slate-800 font-mono">{{ $peserta->email ?? '-' }}</span>
                    </div>
                    <div class="col-span-2 border-t border-slate-100 pt-4 text-xs text-slate-400 font-medium">
                        Keterangan Input: Berkas ini ditambahkan oleh <span class="text-slate-600 font-bold">{{ $peserta->creator->name ?? 'Sistem' }}</span> pada tanggal <span class="text-slate-600 font-semibold">{{ $peserta->created_at->translatedFormat('d F Y (H:i)') }}</span>.
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection