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
                    NISN: <span class="text-slate-700 font-semibold">{{ $peserta->nisn ?? '-' }}</span>
                </p>
            </div>
        </div>
        <a href="{{ route('siswa.data-diri.edit') }}" class="flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white shadow-sm rounded-xl text-xs font-semibold hover:bg-indigo-700 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
            </svg>
            Ubah Data
        </a>
    </div>

<div class="bg-white rounded-xl p-1.5 shadow-sm mb-6 overflow-x-auto">
    <div class="flex min-w-[700px] md:min-w-0 gap-1">

        <button
            @click="activeTab = 'pribadi'"
            :class="activeTab === 'pribadi'
                ? 'bg-indigo-600 text-white shadow-sm'
                : 'text-slate-600 hover:bg-slate-50'"
            class="flex-1 whitespace-nowrap text-center py-2 px-3 rounded-lg text-xs font-semibold uppercase tracking-wider transition">
            1. Biodata Pribadi
        </button>

        <button
            @click="activeTab = 'domisili'"
            :class="activeTab === 'domisili'
                ? 'bg-indigo-600 text-white shadow-sm'
                : 'text-slate-600 hover:bg-slate-50'"
            class="flex-1 whitespace-nowrap text-center py-2 px-3 rounded-lg text-xs font-semibold uppercase tracking-wider transition">
            2. Domisili & Periodik
        </button>

        <button
            @click="activeTab = 'orangtua'"
            :class="activeTab === 'orangtua'
                ? 'bg-indigo-600 text-white shadow-sm'
                : 'text-slate-600 hover:bg-slate-50'"
            class="flex-1 whitespace-nowrap text-center py-2 px-3 rounded-lg text-xs font-semibold uppercase tracking-wider transition">
            3. Orang Tua & Wali
        </button>

        <button
            @click="activeTab = 'kesejahteraan'"
            :class="activeTab === 'kesejahteraan'
                ? 'bg-indigo-600 text-white shadow-sm'
                : 'text-slate-600 hover:bg-slate-50'"
            class="flex-1 whitespace-nowrap text-center py-2 px-3 rounded-lg text-xs font-semibold uppercase tracking-wider transition">
            4. Kesejahteraan & Beasiswa
        </button>

        <button
            @click="activeTab = 'kontak'"
            :class="activeTab === 'kontak'
                ? 'bg-indigo-600 text-white shadow-sm'
                : 'text-slate-600 hover:bg-slate-50'"
            class="flex-1 whitespace-nowrap text-center py-2 px-3 rounded-lg text-xs font-semibold uppercase tracking-wider transition">
            5. Kontak & Akun
        </button>

    </div>
</div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 sm:p-8">

        <div x-show="activeTab === 'pribadi'" class="space-y-6">
            <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider border-b border-slate-100 pb-2">Identitas Utama Siswa</h4>
            <div class="grid sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="block text-xs font-medium text-slate-400">Nama Lengkap</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->nama_lengkap }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Jenis Kelamin</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->jenis_kelamin }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">NISN (Nomor Induk Siswa Nasional)</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->nisn ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">NIK (Nomor Induk Kependudukan)</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->nik ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">No. Kartu Keluarga (KK)</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->no_kk ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">No. Registrasi Akta Lahir</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->no_registrasi_akta ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Tempat, Tanggal Lahir</span>
                    <span class="font-semibold text-slate-800">
                        {{ $peserta->tempat_lahir ?? '-' }}, {{ $peserta->tanggal_lahir ? \Carbon\Carbon::parse($peserta->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                    </span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Kompetensi Keahlian</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->kompetensi_keahlian ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Jalur Pendaftaran</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->jalur_pendaftaran ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Agama</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->agama ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Kewarganegaraan</span>
                    <span class="font-semibold text-slate-800">
                        {{ $peserta->kewarganegaraan }} {{ $peserta->kewarganegaraan === 'WNA' && $peserta->negara_asal ? '('.$peserta->negara_asal.')' : '' }}
                    </span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Anak Ke-</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->anak_ke ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Pekerjaan Siswa (Jika Sambil Bekerja)</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->pekerjaan_siswa ?? 'Tidak Bekerja' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Kebutuhan Khusus</span>
                    <span class="font-semibold text-slate-800">
                        {{ is_array($peserta->berkebutuhan_khusus) ? implode(', ', $peserta->berkebutuhan_khusus) : ($peserta->berkebutuhan_khusus ?? 'Tidak Ada') }}
                    </span>
                </div>
            </div>
        </div>

        <div x-show="activeTab === 'domisili'" class="space-y-6">
            <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider border-b border-slate-100 pb-2">Alamat & Tempat Tinggal</h4>
            <div class="grid sm:grid-cols-2 gap-4 text-sm">
                <div class="sm:col-span-2">
                    <span class="block text-xs font-medium text-slate-400">Alamat Rumah Lengkap</span>
                    <span class="font-semibold text-slate-800">
                        {{ $peserta->alamat ?? '-' }}, RT {{ $peserta->rt ?? '00' }}/RW {{ $peserta->rw ?? '00' }}, Dusun {{ $peserta->dusun ?? '-' }}, Desa {{ $peserta->desa_kelurahan ?? '-' }}, Kec. {{ $peserta->kecamatan ?? '-' }}, Kab. {{ $peserta->kabupaten ?? '-' }}, {{ $peserta->provinsi ?? '-' }}, Kode Pos: {{ $peserta->kode_pos ?? '-' }}
                    </span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Tempat Tinggal</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->tempat_tinggal ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Moda Transportasi Ke Sekolah</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->moda_transportasi ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Koordinat Geografis (Lintang / Bujur)</span>
                    <span class="font-semibold text-slate-800">
                        {{ $peserta->lintang ?? '-' }} / {{ $peserta->bujur ?? '-' }}
                    </span>
                </div>
            </div>

            <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider border-b border-slate-100 pt-4 pb-2">Data Periodik & Fisik</h4>
            <div class="grid sm:grid-cols-3 gap-4 text-sm">
                <div>
                    <span class="block text-xs font-medium text-slate-400">Tinggi Badan</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->tinggi_badan ? $peserta->tinggi_badan . ' cm' : '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Berat Badan</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->berat_badan ? $peserta->berat_badan . ' kg' : '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Jumlah Saudara Kandung</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->jumlah_saudara ?? '0' }} bersaudara</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Kategori Jarak Ke Sekolah</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->jarak_sekolah ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Jarak Detail (Kilometer)</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->jarak_kilometer ? $peserta->jarak_kilometer . ' km' : '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Waktu Tempuh Ke Sekolah</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->waktu_tempuh ? $peserta->waktu_tempuh . ' Menit' : '-' }}</span>
                </div>
            </div>
        </div>

        <div x-show="activeTab === 'orangtua'" class="space-y-6">
            <div class="grid md:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider border-b border-slate-100 pb-2">Data Kandung Ayah</h4>
                    <div class="space-y-2.5 text-sm">
                        <div>
                            <span class="block text-xs font-medium text-slate-400">Nama Ayah</span>
                            <span class="font-semibold text-slate-800">{{ $peserta->nama_ayah ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-medium text-slate-400">NIK Ayah</span>
                            <span class="font-semibold text-slate-800">{{ $peserta->nik_ayah ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-medium text-slate-400">Tahun Lahir Ayah</span>
                            <span class="font-semibold text-slate-800">{{ $peserta->tahun_lahir_ayah ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-medium text-slate-400">Pendidikan Terakhir</span>
                            <span class="font-semibold text-slate-800">{{ $peserta->pendidikan_ayah ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-medium text-slate-400">Pekerjaan Utama</span>
                            <span class="font-semibold text-slate-800">{{ $peserta->pekerjaan_ayah ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-medium text-slate-400">Penghasilan Bulanan</span>
                            <span class="font-semibold text-slate-800">{{ $peserta->penghasilan_ayah ? 'Rp. ' . $peserta->penghasilan_ayah : '-' }}</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider border-b border-slate-100 pb-2">Data Kandung Ibu</h4>
                    <div class="space-y-2.5 text-sm">
                        <div>
                            <span class="block text-xs font-medium text-slate-400">Nama Lengkap Ibu</span>
                            <span class="font-semibold text-slate-800">{{ $peserta->nama_ibu ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-medium text-slate-400">NIK Ibu</span>
                            <span class="font-semibold text-slate-800">{{ $peserta->nik_ibu ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-medium text-slate-400">Tahun Lahir Ibu</span>
                            <span class="font-semibold text-slate-800">{{ $peserta->tahun_lahir_ibu ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-medium text-slate-400">Pendidikan Terakhir</span>
                            <span class="font-semibold text-slate-800">{{ $peserta->pendidikan_ibu ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-medium text-slate-400">Pekerjaan Utama</span>
                            <span class="font-semibold text-slate-800">{{ $peserta->pekerjaan_ibu ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-medium text-slate-400">Penghasilan Bulanan</span>
                            <span class="font-semibold text-slate-800">{{ $peserta->penghasilan_ibu ? 'Rp. ' . $peserta->penghasilan_ibu : '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-100 space-y-4">
                <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider border-b border-slate-100 pb-2">Data Wali (Jika Ada)</h4>
                <div class="grid sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Nama Wali</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->nama_wali ?? 'Tidak Menggunakan Wali' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">NIK Wali</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->nik_wali ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Tahun Lahir Wali</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->tahun_lahir_wali ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Pendidikan Terakhir Wali</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->pendidikan_wali ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Pekerjaan Wali</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->pekerjaan_wali ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="block text-xs font-medium text-slate-400">Penghasilan Bulanan Wali</span>
                        <span class="font-semibold text-slate-800">{{ $peserta->penghasilan_wali ? 'Rp. ' . $peserta->penghasilan_wali : '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="activeTab === 'kesejahteraan'" class="space-y-6">
            <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider border-b border-slate-100 pb-2">Status Program Kesejahteraan</h4>
            <div class="grid sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="block text-xs font-medium text-slate-400">Status Kepemilikan KIP</span>
                    <span class="mt-1 px-2.5 py-0.5 text-xs font-bold rounded-md inline-block {{ $peserta->punya_kip ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600' }}">
                        {{ $peserta->punya_kip ? 'Ya, Memiliki KIP' : 'Tidak Memiliki KIP' }}
                    </span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Status Penerima KIP (Bantuan Cair)</span>
                    <span class="mt-1 px-2.5 py-0.5 text-xs font-bold rounded-md inline-block {{ $peserta->penerima_kip ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600' }}">
                        {{ $peserta->penerima_kip ? 'Ya, Sebagai Penerima PIP/KIP' : 'Bukan Penerima KIP' }}
                    </span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Jenis Jaminan/Kesejahteraan Sosial Lainnya</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->jenis_kesejahteraan ?? 'Tidak Ada' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Nomor Kartu Jaminan</span>
                    <span class="font-semibold text-slate-800 text-mono">{{ $peserta->nomor_kartu_kesejahteraan ?? '-' }}</span>
                </div>
                <div class="sm:col-span-2">
                    <span class="block text-xs font-medium text-slate-400">Nama Pemegang Kartu Jaminan</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->nama_pemegang_kartu ?? '-' }}</span>
                </div>
            </div>

            <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider border-b border-slate-100 pt-4 pb-2">Riwayat Beasiswa Siswa</h4>
            <div class="grid sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="block text-xs font-medium text-slate-400">Jenis Beasiswa</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->jenis_beasiswa ?? 'Tidak Menerima Beasiswa' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Durasi Aktif Beasiswa</span>
                    <span class="font-semibold text-slate-800">
                        @if($peserta->tahun_mulai_beasiswa)
                        Tahun {{ $peserta->tahun_mulai_beasiswa }} s.d {{ $peserta->tahun_selesai_beasiswa ?? 'Sekarang' }}
                        @else
                        -
                        @endif
                    </span>
                </div>
                <div class="sm:col-span-2">
                    <span class="block text-xs font-medium text-slate-400">Keterangan / Deskripsi Beasiswa</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->keterangan_beasiswa ?? '-' }}</span>
                </div>
            </div>
        </div>

        <div x-show="activeTab === 'kontak'" class="space-y-6">
            <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider border-b border-slate-100 pb-2">Informasi Kontak Respon Cepat</h4>
            <div class="grid sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="block text-xs font-medium text-slate-400">Nomor HP / WhatsApp Mandiri</span>
                    <span class="font-semibold text-slate-800 text-indigo-600">{{ $peserta->no_hp ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Nomor HP Orang Tua (Darurat)</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->no_hp_ortu ?? '-' }}</span>
                </div>
                <div class="sm:col-span-2">
                    <span class="block text-xs font-medium text-slate-400">Email Aktif Peserta</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->email ?? '-' }}</span>
                </div>
            </div>

            <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider border-b border-slate-100 pt-4 pb-2">Log Audit Sistem</h4>
            <div class="grid sm:grid-cols-2 gap-4 text-sm bg-slate-50 p-4 rounded-xl border border-slate-100">
                <div>
                    <span class="block text-xs font-medium text-slate-400">ID User Terkait (Relasi)</span>
                    <span class="font-semibold text-slate-700">User ID: {{ $peserta->user_id ?? 'Tidak Terhubung' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Petugas Input / Kreator Berkas</span>
                    <span class="font-semibold text-slate-700">{{ $peserta->creator->name ?? 'Sistem / Mandiri' }}</span>
                </div>
                <div class="sm:col-span-2 border-t border-slate-200/60 pt-3 mt-2 text-xs text-slate-400 font-medium">
                    Berkas pendaftaran digital ini dibuat pada <span class="text-slate-600 font-bold">{{ $peserta->created_at->format('d/m/Y H:i') }} WIB</span> dan terakhir diperbarui pada <span class="text-slate-600 font-bold">{{ $peserta->updated_at->format('d/m/Y H:i') }} WIB</span>.
                </div>
            </div>
        </div>

    </div>
</div>
@endsection