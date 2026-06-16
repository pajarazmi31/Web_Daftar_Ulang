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
                    No. Pendaftaran: <span class="text-indigo-600 font-semibold">{{ $peserta->nomor_pendaftaran ?? '-' }}</span> &bull; 
                    NISN: <span class="text-slate-700 font-semibold">{{ $peserta->nisn ?? '-' }}</span>
                </p>
            </div>
        </div>
        <a href="{{ route('data-peserta') }}" class="flex items-center gap-2 px-4 py-2 bg-slate-50 hover:bg-slate-100 border border-slate-200 rounded-xl text-xs font-semibold text-slate-600 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke List
        </a>
    </div>

    <div class="flex border-b border-slate-200 overflow-x-auto mb-6 bg-white rounded-xl p-1.5 shadow-sm min-w-max">
        <button @click="activeTab = 'pribadi'" :class="activeTab === 'pribadi' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-50'" class="flex-1 text-center py-2 px-4 rounded-lg text-xs font-semibold uppercase tracking-wider transition">
            1. Biodata Pribadi
        </button>
        <button @click="activeTab = 'orangtua'" :class="activeTab === 'orangtua' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-50'" class="flex-1 text-center py-2 px-4 rounded-lg text-xs font-semibold uppercase tracking-wider transition">
            2. Data Orang Tua
        </button>
        <button @click="activeTab = 'wali'" :class="activeTab === 'wali' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-50'" class="flex-1 text-center py-2 px-4 rounded-lg text-xs font-semibold uppercase tracking-wider transition">
            3. Wali & Kontak
        </button>
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
                    <span class="block text-xs font-medium text-slate-400">NIK (Nomor Induk Kependudukan)</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->nik }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">No. Kartu Keluarga (KK)</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->no_kk }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Tempat, Tanggal Lahir</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->tempat_lahir }}, {{ \Carbon\Carbon::parse($peserta->tanggal_lahir)->translatedFormat('d F Y') }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">No. Registrasi Akta Lahir</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->no_registrasi_akta ?? '-' }}</span>
                </div>
            </div>

            <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider border-b border-slate-100 pt-4 pb-2">Domisili & Kesejahteraan</h4>
            <div class="grid sm:grid-cols-2 gap-4 text-sm">
                <div class="sm:col-span-2">
                    <span class="block text-xs font-medium text-slate-400">Alamat Rumah Lengkap</span>
                    <span class="font-semibold text-slate-800">
                        {{ $peserta->alamat }}, RT {{ $peserta->rt }}/RW {{ $peserta->rw }}, Dusun {{ $peserta->dusun }}, Desa {{ $peserta->desa_kelurahan }}, Kec. {{ $peserta->kecamatan }}, {{ $peserta->kode_pos }}
                    </span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Status Kepemilikan KIP</span>
                    <span class="px-2.5 py-0.5 text-xs font-bold rounded-md inline-block {{ $peserta->punya_kip ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-slate-100 text-slate-600' }}">
                        {{ $peserta->punya_kip ? 'Ya, Memiliki KIP' : 'Tidak Memiliki KIP' }}
                    </span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Kebutuhan Khusus</span>
                    <span class="font-semibold text-slate-800">
                        {{ is_array($peserta->berkebutuhan_khusus) ? implode(', ', $peserta->berkebutuhan_khusus) : ($peserta->berkebutuhan_khusus ?? 'Tidak Ada') }}
                    </span>
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
                            <span class="block text-xs font-medium text-slate-400">Pendidikan Terakhir</span>
                            <span class="font-semibold text-slate-800">{{ $peserta->pendidikan_ayah ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-medium text-slate-400">Pekerjaan Utama</span>
                            <span class="font-semibold text-slate-800">{{ $peserta->pekerjaan_ayah ?? '-' }}</span>
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
                            <span class="block text-xs font-medium text-slate-400">Pendidikan Terakhir</span>
                            <span class="font-semibold text-slate-800">{{ $peserta->pendidikan_ibu ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-medium text-slate-400">Pekerjaan Utama</span>
                            <span class="font-semibold text-slate-800">{{ $peserta->pekerjaan_ibu ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="activeTab === 'wali'" class="space-y-6">
            <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider border-b border-slate-100 pb-2">Data Wali (Jika Ada)</h4>
            <div class="grid sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="block text-xs font-medium text-slate-400">Nama Wali</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->nama_wali ?? 'Tidak Menggunakan Wali' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Pekerjaan Wali</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->pekerjaan_wali ?? '-' }}</span>
                </div>
            </div>

            <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider border-b border-slate-100 pt-4 pb-2">Kontak & Log Sistem</h4>
            <div class="grid sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="block text-xs font-medium text-slate-400">Nomor HP / WhatsApp</span>
                    <span class="font-semibold text-slate-800 text-indigo-600">{{ $peserta->no_hp ?? '-' }}</span>
                </div>
                <div>
                    <span class="block text-xs font-medium text-slate-400">Email Aktif</span>
                    <span class="font-semibold text-slate-800">{{ $peserta->email ?? '-' }}</span>
                </div>
                <div class="sm:col-span-2 border-t border-slate-50 pt-4 text-xs text-slate-400 font-medium">
                    Keterangan Input: Berkas ini ditambahkan oleh <span class="text-slate-600 font-bold">{{ $peserta->creator->name ?? 'Sistem' }}</span> pada tanggal {{ $peserta->created_at->format('d/m/Y H:i') }} WIB.
                </div>
            </div>
        </div>

    </div>
</div>
@endsection