@extends('layouts.dashboard')

@section('title', 'Detail Profil Peserta Didik')

@section('header_title')
Profil Detail: {{ $siswa->nama_lengkap }}
@endsection

@section('header_subtitle')
No. Pendaftaran: {{ $siswa->nomor_pendaftaran ?? 'Belum Terbit' }} | Status: {{ $siswa->status_registrasi ?? 'Draft' }}
@endsection

@section('content')


<div class="space-y-6 antialiased text-slate-700">

    <div class="flex items-center justify-between print:hidden">
        <a href="{{ route('laporan.kepsek') }}" class="inline-flex items-center gap-2 bg-white border border-slate-200 hover:bg-slate-50 text-sm font-medium text-slate-600 px-4 py-2 rounded-xl transition shadow-sm">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            <span>Kembali ke Laporan</span>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.174L10.74 5.2a1.5 1.5 0 011.851 0l6.48 4.974A1.5 1.5 0 0119.5 11.39V18a1.5 1.5 0 01-1.5 1.5H6a1.5 1.5 0 01-1.5-1.5v-6.61a1.5 1.5 0 01.76-1.216z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19.5v-6a1.5 1.5 0 011.5-1.5h3a1.5 1.5 0 011.5 1.5v6" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kompetensi Keahlian</p>
                <h4 class="text-sm font-bold text-slate-800 mt-0.5">{{ $siswa->kompetensi_keahlian ?? 'Belum Memilih' }}</h4>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0012 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sekolah Asal</p>
                <h4 class="text-sm font-bold text-slate-800 mt-0.5">{{ $siswa->sekolah_asal ?? '-' }}</h4>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Jenis Pendaftaran</p>
                <h4 class="text-sm font-bold text-slate-800 mt-0.5">{{ $siswa->jenis_pendaftaran ?? '-' }}</h4>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <!-- Header Bagian -->
        <div class="px-6 py-4 bg-slate-50/70 border-b border-slate-100">
            <h3 class="font-bold text-xs uppercase tracking-wider text-indigo-600">I. Data Pribadi Calon Siswa</h3>
        </div>

        <!-- Konten Grid Data -->
        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-5 gap-x-8 text-sm">
            <!-- Nama Lengkap -->
            <div>
                <span class="text-xs font-medium text-slate-400 block">Nama Lengkap</span>
                <span class="font-semibold text-slate-900 mt-0.5 block">{{ $siswa->nama_lengkap }}</span>
            </div>

            <!-- Jenis Kelamin -->
            <div>
                <span class="text-xs font-medium text-slate-400 block">Jenis Kelamin</span>
                <span class="font-semibold text-slate-900 mt-0.5 block">{{ $siswa->jenis_kelamin }}</span>
            </div>

            <!-- Tempat, Tanggal Lahir -->
            <div>
                <span class="text-xs font-medium text-slate-400 block">Tempat, Tanggal Lahir</span>
                <span class="font-semibold text-slate-900 mt-0.5 block">
                    {{ $siswa->tempat_lahir }}, {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->translatedFormat('d F Y') }}
                </span>
            </div>

            <!-- NISN -->
            <div>
                <span class="text-xs font-medium text-slate-400 block">NISN</span>
                <span class="font-mono font-semibold text-slate-900 mt-0.5 block">{{ $siswa->nisn ?? '-' }}</span>
            </div>

            <!-- NIK / No. KK -->
            <div>
                <span class="text-xs font-medium text-slate-400 block">NIK / No. KK</span>
                <span class="font-mono font-semibold text-slate-900 mt-0.5 block">{{ $siswa->nik }} / {{ $siswa->no_kk }}</span>
            </div>

            <!-- No. Registrasi Akta -->
            <div>
                <span class="text-xs font-medium text-slate-400 block">No. Registrasi Akta</span>
                <span class="font-mono font-semibold text-slate-900 mt-0.5 block">{{ $siswa->no_registrasi_akta ?? '-' }}</span>
            </div>

            <!-- Agama -->
            <div>
                <span class="text-xs font-medium text-slate-400 block">Agama</span>
                <span class="font-semibold text-slate-900 mt-0.5 block">{{ $siswa->agama }}</span>
            </div>
            <!-- Pekerjaan Siswa -->
            <div>
                <span class="text-xs font-medium text-slate-400 block">Pekerjaan Siswa</span>
                <span class="font-semibold text-slate-900 mt-0.5 block">{{ $siswa->pekerjaan_siswa ?? '-' }}</span>
            </div>

            <!-- Anak Ke / Jumlah Saudara -->
            <div>
                <span class="text-xs font-medium text-slate-400 block">Anak Ke / Jumlah Saudara</span>
                <span class="font-semibold text-slate-900 mt-0.5 block">
                    Anak ke-{{ $siswa->anak_ke ?? '-' }} dari {{ $siswa->jumlah_saudara ?? '-' }} bersaudara
                </span>
            </div>

            <!-- Moda Transportasi / Tempat Tinggal -->
            <div>
                <span class="text-xs font-medium text-slate-400 block">Moda Transportasi / Tempat Tinggal</span>
                <span class="font-semibold text-slate-900 mt-0.5 block">{{ $siswa->moda_transportasi ?? '-' }} / {{ $siswa->tempat_tinggal ?? '-' }}</span>
            </div>



            <!-- Kewarganegaraan -->
            <div>
                <span class="text-xs font-medium text-slate-400 block">Kewarganegaraan</span>
                <span class="font-semibold text-slate-900 mt-0.5 block">
                    {{ $siswa->kewarganegaraan }} @if($siswa->negara_asal) ({{ $siswa->negara_asal }}) @endif
                </span>
            </div>


            <!-- Alamat Rumah Lengkap (Full-width Column) -->
            <div class="sm:col-span-2 lg:col-span-3">
                <span class="text-xs font-medium text-slate-400 block">Alamat Rumah Lengkap</span>
                <span class="font-semibold text-slate-900 mt-0.5 block leading-relaxed">
                    {{ $siswa->alamat }} @if($siswa->rt) RT {{ $siswa->rt }} / RW {{ $siswa->rw }} @endif,
                    Dusun: {{ $siswa->dusun ?? '-' }}, Kel/Desa: {{ $siswa->desa_kelurahan }},
                    Kec: {{ $siswa->kecamatan }}, Kode Pos: {{ $siswa->kode_pos ?? '-' }}
                </span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-slate-50/70 border-b border-slate-100">
            <h3 class="font-bold text-xs uppercase tracking-wider text-indigo-600">II. Profil Orang Tua & Wali</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-8 divide-y md:divide-y-0 md:divide-x divide-slate-100 text-sm">

            <div class="space-y-3.5">
                <h4 class="font-bold text-xs uppercase text-slate-400 tracking-wider flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    <span>Data Ayah Kandung</span>
                </h4>
                <div>
                    <span class="text-xs text-slate-400 block">Nama Ayah</span>
                    <span class="font-semibold text-slate-950">{{ $siswa->nama_ayah ?? 'Tidak Diisi' }}</span>
                </div>
                @if($siswa->nama_ayah)
                <div>
                    <span class="text-xs text-slate-400 block">NIK / Tahun Lahir</span>
                    <span class="font-mono font-medium text-slate-600">{{ $siswa->nik_ayah ?? '-' }} / {{ $siswa->tahun_lahir_ayah ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Pendidikan & Pekerjaan</span>
                    <span class="font-medium text-slate-600">{{ $siswa->pendidikan_ayah ?? '-' }} / {{ $siswa->pekerjaan_ayah ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Penghasilan Bulanan</span>
                    <span class="font-semibold text-emerald-600">Rp. {{ $siswa->penghasilan_ayah ?? 0 }}</span>
                </div>
                @endif
            </div>

            <div class="space-y-3.5 md:pl-8 pt-4 md:pt-0">
                <h4 class="font-bold text-xs uppercase text-slate-400 tracking-wider flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    <span>Data Ibu Kandung</span>
                </h4>
                <div>
                    <span class="text-xs text-slate-400 block">Nama Ibu</span>
                    <span class="font-semibold text-slate-950">{{ $siswa->nama_ibu ?? 'Tidak Diisi' }}</span>
                </div>
                @if($siswa->nama_ibu)
                <div>
                    <span class="text-xs text-slate-400 block">NIK / Tahun Lahir</span>
                    <span class="font-mono font-medium text-slate-600">{{ $siswa->nik_ibu ?? '-' }} / {{ $siswa->tahun_lahir_ibu ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Pendidikan & Pekerjaan</span>
                    <span class="font-medium text-slate-600">{{ $siswa->pendidikan_ibu ?? '-' }} / {{ $siswa->pekerjaan_ibu ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Penghasilan Bulanan</span>
                    <span class="font-semibold text-emerald-600">Rp. {{$siswa->penghasilan_ibu ?? 0}}</span>
                </div>
                @endif
            </div>

            <div class="space-y-3.5 md:pl-8 pt-4 md:pt-0">
                <h4 class="font-bold text-xs uppercase text-slate-400 tracking-wider flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM3 19.235v-.11a6 6 0 016-6h1.5a6 6 0 016 6v.11c0 .323-.102.637-.29.897L15 21H3l-.71-.878a1.123 1.123 0 01-.29-.887z" />
                    </svg>
                    <span>Data Wali (Jika Ada)</span>
                </h4>
                <div>
                    <span class="text-xs text-slate-400 block">Nama Wali</span>
                    <span class="font-semibold text-slate-950">{{ $siswa->nama_wali ?? 'Tidak Menggunakan Wali' }}</span>
                </div>
                @if($siswa->nama_wali)
                <div>
                    <span class="text-xs text-slate-400 block">NIK / Tahun Lahir</span>
                    <span class="font-mono font-medium text-slate-600">{{ $siswa->nik_wali ?? '-' }} / {{ $siswa->tahun_lahir_wali ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Pendidikan & Pekerjaan</span>
                    <span class="font-medium text-slate-600">{{ $siswa->pendidikan_wali ?? '-' }} / {{ $siswa->pekerjaan_wali ?? '-' }} </span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Penghasilan</span>
                    <span class="text-emerald-600 font-semibold">Rp. {{$siswa->penghasilan_wali ?? 0}}</span></span>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-slate-50/70 border-b border-slate-100">
                <h3 class="font-bold text-xs uppercase tracking-wider text-indigo-600">III. Kontak & Kondisi Fisik</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="text-xs text-slate-400 block">No. HP Siswa</span>
                        <span class="font-semibold text-slate-800">{{ $siswa->no_hp ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">No. HP Orang Tua</span>
                        <span class="font-semibold text-slate-800">{{ $siswa->no_hp_ortu ?? '-' }}</span>
                    </div>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Alamat Email</span>
                    <span class="font-semibold text-slate-800 text-sm">{{ $siswa->email ?? '-' }}</span>
                </div>
                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-100">
                    <div>
                        <span class="text-xs text-slate-400 block">Tinggi Badan</span>
                        <span class="font-semibold text-slate-800">{{ $siswa->tinggi_badan ?? '-' }} cm</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">Berat Badan</span>
                        <span class="font-semibold text-slate-800">{{ $siswa->berat_badan ?? '-' }} kg</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">Jarak Kilometer</span>
                        <span class="font-semibold text-slate-800">{{ $siswa->jarak_kilometer ?? '-' }} km</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">Waktu Tempuh</span>
                        <span class="font-semibold text-slate-800">{{ $siswa->waktu_tempuh ?? '-' }} Menit</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden lg:col-span-2">
            <div class="px-6 py-4 bg-slate-50/70 border-b border-slate-100">
                <h3 class="font-bold text-xs uppercase tracking-wider text-indigo-600">IV. Kesejahteraan & Beasiswa</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <span class="text-xs text-slate-400 block">Nama Pemegang Kartu</span>
                        <span class="font-semibold text-slate-800">{{ $siswa->nama_pemegang_kartu ?? 'Tidak Ada' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">Nomer Kartu</span>
                        <span class="font-semibold text-slate-800">{{ $siswa->nomor_kartu_kesejahteraan ?? 'Tidak Ada' }}</span>
                    </div>
                                        <div>
                        <span class="text-xs text-slate-400 block">Jenis Kesejahteraan</span>
                        <span class="font-semibold text-slate-800">{{ $siswa->jenis_kesejahteraan ?? 'Tidak Ada' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">Memiliki KIP</span>
                        <span class="px-2 py-0.5 rounded-md text-xs font-bold inline-block mt-1 {{ $siswa->punya_kip ? 'bg-indigo-50 text-indigo-700 border border-indigo-100' : 'bg-slate-100 text-slate-500' }}">
                            {{ $siswa->punya_kip ? 'Ya (Memiliki)' : 'Tidak' }}
                        </span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">Penerima Bantuan KIP</span>
                        <span class="px-2 py-0.5 rounded-md text-xs font-bold inline-block mt-1 {{ $siswa->penerima_kip ? 'bg-emerald-50 text-emerald-700 border border-emerald-100' : 'bg-slate-100 text-slate-500' }}">
                            {{ $siswa->penerima_kip ? 'Ya (Aktif Menerima)' : 'Tidak' }}
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-100">
                    <div>
                        <span class="text-xs text-slate-400 block">Jenis Beasiswa</span>
                        <span class="font-semibold text-slate-800">{{ $siswa->jenis_beasiswa ?? 'Tidak Ada' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">Keterangan Beasiswa</span>
                        <span class="font-semibold text-slate-800 ">{{ $siswa->keterangan_beasiswa ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">Tahun Mulai Beasiswa</span>
                        <span class="font-semibold text-slate-800 ">{{ $siswa->tahun_mulai_beasiswa ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">Tahun Selesai Beasiswa</span>
                        <span class="font-semibold text-slate-800 ">{{ $siswa->tahun_selesai_beasiswa ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-slate-50/70 border-b border-slate-100">
            <h3 class="font-bold text-xs uppercase tracking-wider text-indigo-600">V. Berkas Lampiran Digital</h3>
        </div>
        <div class="p-6 grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
            @php
            $berkas = [
            ['label' => 'Kartu Keluarga (KK)', 'field' => $siswa->kk],
            ['label' => 'KTP Orang Tua', 'field' => $siswa->ktp_ortu],
            ['label' => 'Akta Kelahiran', 'field' => $siswa->akta_kelahiran],
            ['label' => 'SKL / Ijazah', 'field' => $siswa->surat_keterangan_lulus],
            ['label' => 'Kartu Kesejahteraan', 'field' => $siswa->kartu_kesejahteraan],
            ['label' => 'SPTJM', 'field' => $siswa->sptjm],
            ['label' => 'Surat Pernyataan Tata Tertib', 'field' => $siswa->surat_pernyataan_tata_tertib],
            ];
            @endphp

            @foreach($berkas as $file)
            <div class="p-4 bg-slate-50 border border-slate-100 rounded-2xl text-center flex flex-col justify-between items-center min-h-[110px]">
                <span class="text-slate-500 font-semibold block mb-2">{{ $file['label'] }}</span>
                @if($file['field'])
                <a href="{{ asset('storage/' . $file['field']) }}" target="_blank" class="inline-flex items-center gap-1 text-indigo-600 font-bold hover:text-indigo-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Buka File</span>
                </a>
                @else
                <span class="inline-flex items-center gap-1 text-slate-400 italic">
                    <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                    </svg>
                    <span>Belum Upload</span>
                </span>
                @endif
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection