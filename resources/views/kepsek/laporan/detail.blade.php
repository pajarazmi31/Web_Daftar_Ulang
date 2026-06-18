@extends('layouts.dashboard')

@section('title', 'Detail Profil Peserta Didik')

@section('header_title')
Profil Detail: {{ $siswa->nama_lengkap }}
@endsection

@section('header_subtitle')
No. Pendaftaran: {{ $siswa->nomor_pendaftaran ?? 'Belum Terbit' }} | Status: {{ $siswa->status_registrasi ?? 'Draft' }}
@endsection

@section('content')
<div class="space-y-8 antialiased text-slate-700">
    
    <div class="flex items-center justify-between">
        <a href="{{ route('laporan.kepsek') }}" class="inline-flex items-center space-x-2 bg-white border border-slate-200 hover:bg-slate-50 text-sm font-medium text-slate-600 px-4 py-2 rounded-xl transition shadow-sm">
            <span>←</span> <span>Kembali ke Laporan</span>
        </a>
        <button onclick="window.print()" class="bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium px-4 py-2 rounded-xl transition shadow-sm inline-flex items-center space-x-2">
            <span>🖨️</span> <span>Cetak Profil</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl text-xl">🎓</div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kompetensi Keahlian</p>
                <h4 class="text-base font-bold text-slate-800 mt-0.5">{{ $siswa->kompetensi_keahlian ?? 'Belum Memilih' }}</h4>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl text-xl">🏫</div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Sekolah Asal</p>
                <h4 class="text-base font-bold text-slate-800 mt-0.5">{{ $siswa->sekolah_asal ?? '-' }}</h4>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm flex items-center space-x-4">
            <div class="p-3 bg-amber-50 text-amber-600 rounded-xl text-xl">📝</div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Jenis Pendaftaran</p>
                <h4 class="text-base font-bold text-slate-800 mt-0.5">{{ $siswa->jenis_pendaftaran ?? '-' }}</h4>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-slate-50/70 border-b border-slate-100">
            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider text-indigo-600">I. Data Pribadi Calon Siswa</h3>
        </div>
        <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-5 gap-x-8 text-sm">
            <div>
                <span class="text-xs font-medium text-slate-400 block">Nama Lengkap</span>
                <span class="font-semibold text-slate-900 mt-0.5 block">{{ $siswa->nama_lengkap }}</span>
            </div>
            <div>
                <span class="text-xs font-medium text-slate-400 block">Jenis Kelamin</span>
                <span class="font-semibold text-slate-900 mt-0.5 block">{{ $siswa->jenis_kelamin }}</span>
            </div>
            <div>
                <span class="text-xs font-medium text-slate-400 block">Agama</span>
                <span class="font-semibold text-slate-900 mt-0.5 block">{{ $siswa->agama }}</span>
            </div>
            <div>
                <span class="text-xs font-medium text-slate-400 block">NISN</span>
                <span class="font-mono font-semibold text-slate-900 mt-0.5 block">{{ $siswa->nisn ?? '-' }}</span>
            </div>
            <div>
                <span class="text-xs font-medium text-slate-400 block">NIK / No. KK</span>
                <span class="font-mono font-semibold text-slate-900 mt-0.5 block">{{ $siswa->nik }} / {{ $siswa->no_kk }}</span>
            </div>
            <div>
                <span class="text-xs font-medium text-slate-400 block">Tempat, Tanggal Lahir</span>
                <span class="font-semibold text-slate-900 mt-0.5 block">{{ $siswa->tempat_lahir }}, {{ \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d F Y') }}</span>
            </div>
            <div class="sm:col-span-2 lg:col-span-3">
                <span class="text-xs font-medium text-slate-400 block">Alamat Rumah Lengkap</span>
                <span class="font-semibold text-slate-900 mt-0.5 block">
                    {{ $siswa->alamat }} @if($siswa->rt) RT {{ $siswa->rt }} / RW {{ $siswa->rw }} @endif, Dusun: {{ $siswa->dusun ?? '-' }}, Kel/Desa: {{ $siswa->desa_kelurahan }}, Kec: $siswa->kecamatan, Kode Pos: {{ $siswa->kode_pos ?? '-' }}
                </span>
            </div>
            <div>
                <span class="text-xs font-medium text-slate-400 block">Moda Transportasi / Tempat Tinggal</span>
                <span class="font-semibold text-slate-900 mt-0.5 block">{{ $siswa->moda_transportasi ?? '-' }} / {{ $siswa->tempat_tinggal ?? '-' }}</span>
            </div>
            <div>
                <span class="text-xs font-medium text-slate-400 block">Kewarganegaraan</span>
                <span class="font-semibold text-slate-900 mt-0.5 block">{{ $siswa->kewarganegaraan }} @if($siswa->negara_asal) ({{ $siswa->negara_asal }}) @endif</span>
            </div>
            <div>
                <span class="text-xs font-medium text-slate-400 block">Anak Ke / Jumlah Saudara</span>
                <span class="font-semibold text-slate-900 mt-0.5 block">Anak ke-{{ $siswa->anak_ke ?? '-' }} dari {{ $siswa->jumlah_saudara ?? '-' }} bersaudara</span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-slate-50/70 border-b border-slate-100">
            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider text-indigo-600">II. Profil Orang Tua & Wali</h3>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-8 divide-y md:divide-y-0 md:divide-x divide-slate-100 text-sm">
            
            <div class="space-y-3.5">
                <h4 class="font-bold text-slate-800 text-xs uppercase text-slate-400 tracking-wider">👨 Data Ayah Kandung</h4>
                <div>
                    <span class="text-xs text-slate-400 block">Nama Ayah</span>
                    <span class="font-semibold text-slate-950">{{ $siswa->nama_ayah ?? 'Tidak Diisi' }}</span>
                </div>
                @if($siswa->nama_ayah)
                <div>
                    <span class="text-xs text-slate-400 block">NIK / Tahun Lahir</span>
                    <span class="font-mono font-medium">{{ $siswa->nik_ayah ?? '-' }} / {{ $siswa->tahun_lahir_ayah ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Pendidikan & Pekerjaan</span>
                    <span class="font-medium">{{ $siswa->pendidikan_ayah ?? '-' }} / {{ $siswa->pekerjaan_ayah ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Penghasilan Bulanan</span>
                    <span class="font-semibold text-emerald-600">Rp. {{ $siswa->penghasilan_ayah ?? '0' }}</span>
                </div>
                @endif
            </div>

            <div class="space-y-3.5 md:pl-8">
                <h4 class="font-bold text-slate-800 text-xs uppercase text-slate-400 tracking-wider pt-4 md:pt-0">👩 Data Ibu Kandung</h4>
                <div>
                    <span class="text-xs text-slate-400 block">Nama Ibu</span>
                    <span class="font-semibold text-slate-950">{{ $siswa->nama_ibu ?? 'Tidak Diisi' }}</span>
                </div>
                @if($siswa->nama_ibu)
                <div>
                    <span class="text-xs text-slate-400 block">NIK / Tahun Lahir</span>
                    <span class="font-mono font-medium">{{ $siswa->nik_ibu ?? '-' }} / {{ $siswa->tahun_lahir_ibu ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Pendidikan & Pekerjaan</span>
                    <span class="font-medium">{{ $siswa->pendidikan_ibu ?? '-' }} / {{ $siswa->pekerjaan_ibu ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Penghasilan Bulanan</span>
                    <span class="font-semibold text-emerald-600">Rp. {{ $siswa->penghasilan_ibu ?? '0' }}</span>
                </div>
                @endif
            </div>

            <div class="space-y-3.5 md:pl-8">
                <h4 class="font-bold text-slate-800 text-xs uppercase text-slate-400 tracking-wider pt-4 md:pt-0">👤 Data Wali (Jika Ada)</h4>
                <div>
                    <span class="text-xs text-slate-400 block">Nama Wali</span>
                    <span class="font-semibold text-slate-950">{{ $siswa->nama_wali ?? 'Tidak Menggunakan Wali' }}</span>
                </div>
                @if($siswa->nama_wali)
                <div>
                    <span class="text-xs text-slate-400 block">NIK / Pendidikan</span>
                    <span class="font-medium">{{ $siswa->nik_wali ?? '-' }} / {{ $siswa->pendidikan_wali ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-xs text-slate-400 block">Pekerjaan & Penghasilan</span>
                    <span class="font-medium">{{ $siswa->pekerjaan_wali ?? '-' }} / Rp. {{ $siswa->penghasilan_wali ?? '0' }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
        
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-slate-50/70 border-b border-slate-100">
                <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider text-indigo-600">III. Kontak & Kondisi Fisik</h3>
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
                    <span class="font-semibold text-slate-800 font-mono text-xs">{{ $siswa->email ?? '-' }}</span>
                </div>
                <div class="grid grid-cols-3 gap-4 pt-2 border-t border-slate-50">
                    <div>
                        <span class="text-xs text-slate-400 block">Tinggi Badan</span>
                        <span class="font-semibold text-slate-800">{{ $siswa->tinggi_badan ?? '-' }} cm</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">Berat Badan</span>
                        <span class="font-semibold text-slate-800">{{ $siswa->berat_badan ?? '-' }} kg</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">Waktu Tempuh</span>
                        <span class="font-semibold text-slate-800">{{ $siswa->waktu_tempuh ?? '-' }} Menit</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 bg-slate-50/70 border-b border-slate-100">
                <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider text-indigo-600">IV. Jaminan Kesejahteraan & Beasiswa</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <span class="text-xs text-slate-400 block">Memiliki KIP</span>
                        <span class="px-2 py-0.5 rounded text-xs font-bold inline-block mt-1 {{ $siswa->punya_kip ? 'bg-indigo-50 text-indigo-700' : 'bg-slate-100 text-slate-500' }}">
                            {{ $siswa->punya_kip ? 'Ya (Memiliki)' : 'Tidak' }}
                        </span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">Penerima Bantuan KIP</span>
                        <span class="px-2 py-0.5 rounded text-xs font-bold inline-block mt-1 {{ $siswa->penerima_kip ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                            {{ $siswa->penerima_kip ? 'Ya (Aktif Menerima)' : 'Tidak' }}
                        </span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 pt-2 border-t border-slate-50">
                    <div>
                        <span class="text-xs text-slate-400 block">Jenis Beasiswa</span>
                        <span class="font-semibold text-slate-800">{{ $siswa->jenis_beasiswa ?? 'Tidak Ada' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-400 block">Keterangan Beasiswa</span>
                        <span class="font-semibold text-slate-800 text-xs">{{ $siswa->keterangan_beasiswa ?? '-' }}</span>
                    </div>
                </div>
                <div class="pt-2 border-t border-slate-50">
                    <span class="text-xs text-slate-400 block">Kartu Kesejahteraan Non-KIP (PKH/PIP/KKS/KJS)</span>
                    <span class="font-semibold text-slate-800">
                        @if($siswa->jenis_kesejahteraan)
                            {{ $siswa->jenis_kesejahteraan }} (No: {{ $siswa->nomor_kartu_kesejahteraan ?? '-' }} a.n {{ $siswa->nama_pemegang_kartu ?? '-' }})
                        @else
                            Tidak Ada
                        @endif
                    </span>
                </div>
            </div>
        </div>

    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 bg-slate-50/70 border-b border-slate-100">
            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider text-indigo-600">V. Berkas Lampiran Digital (Upload Operator)</h3>
        </div>
        <div class="p-6 grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 text-xs">
            <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl text-center">
                <p class="text-slate-400 font-medium mb-2">Kartu Keluarga (KK)</p>
                @if($siswa->kk) <a href="{{ asset('storage/' . $siswa->kk) }}" target="_blank" class="text-indigo-600 font-bold hover:underline">👁️ Buka File</a> @else <span class="text-slate-400 italic">Belum Upload</span> @endif
            </div>
            <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl text-center">
                <p class="text-slate-400 font-medium mb-2">KTP Orang Tua</p>
                @if($siswa->ktp_ortu) <a href="{{ asset('storage/' . $siswa->ktp_ortu) }}" target="_blank" class="text-indigo-600 font-bold hover:underline">👁️ Buka File</a> @else <span class="text-slate-400 italic">Belum Upload</span> @endif
            </div>
            <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl text-center">
                <p class="text-slate-400 font-medium mb-2">Akta Kelahiran</p>
                @if($siswa->akta_kelahiran) <a href="{{ asset('storage/' . $siswa->akta_kelahiran) }}" target="_blank" class="text-indigo-600 font-bold hover:underline">👁️ Buka File</a> @else <span class="text-slate-400 italic">Belum Upload</span> @endif
            </div>
            <div class="p-3 bg-slate-50 border border-slate-100 rounded-xl text-center">
                <p class="text-slate-400 font-medium mb-2">SKL / Ijazah</p>
                @if($siswa->surat_keterangan_lulus) <a href="{{ asset('storage/' . $siswa->surat_keterangan_lulus) }}" target="_blank" class="text-indigo-600 font-bold hover:underline">👁️ Buka File</a> @else <span class="text-slate-400 italic">Belum Upload</span> @endif
            </div>
        </div>
    </div>

</div>
@endsection