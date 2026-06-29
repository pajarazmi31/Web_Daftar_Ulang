@extends('layouts.dashboard')

@section('title', 'Data Diri Siswa')
@section('header_title', 'Data Diri Anda')
@section('header_subtitle', 'Periksa kembali data Anda, lakukan perubahan jika ada kesalahan.')

@section('content')
<div class="max-w-5xl mx-auto" x-data="{
    tab: '{{ old('tab', 'pribadi') }}',
    kwn: '{{ old('kewarganegaraan', $peserta->kewarganegaraan ?? 'WNI') }}',
    tabs: ['pribadi', 'ayah', 'ibu', 'wali', 'kontak', 'beasiswa']
}">

    @if(!$peserta)
    <div class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm text-slate-500 text-sm">
        Data diri belum diisi oleh operator. Silakan hubungi bagian administrasi atau lakukan registrasi mandiri jika tersedia.
    </div>
    @else
    <div class="flex border-b border-slate-200 overflow-x-auto mb-6 bg-white rounded-xl p-1.5 shadow-sm min-w-max">
        <button type="button" @click="tab = 'pribadi'" :class="tab === 'pribadi' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-50'" class="flex-1 text-center py-2.5 px-4 rounded-lg text-xs font-semibold uppercase tracking-wider transition-all duration-150">
            1. Data Pribadi
        </button>
        <button type="button" @click="tab = 'ayah'" :class="tab === 'ayah' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-50'" class="flex-1 text-center py-2.5 px-4 rounded-lg text-xs font-semibold uppercase tracking-wider transition-all duration-150">
            2. Data Ayah
        </button>
        <button type="button" @click="tab = 'ibu'" :class="tab === 'ibu' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-50'" class="flex-1 text-center py-2.5 px-4 rounded-lg text-xs font-semibold uppercase tracking-wider transition-all duration-150">
            3. Data Ibu
        </button>
        <button type="button" @click="tab = 'wali'" :class="tab === 'wali' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-50'" class="flex-1 text-center py-2.5 px-4 rounded-lg text-xs font-semibold uppercase tracking-wider transition-all duration-150">
            4. Data Wali
        </button>
        <button type="button" @click="tab = 'kontak'" :class="tab === 'kontak' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-50'" class="flex-1 text-center py-2.5 px-4 rounded-lg text-xs font-semibold uppercase tracking-wider transition-all duration-150">
            5. Kontak & Rincian Data
        </button>
        <button type="button" @click="tab = 'beasiswa'" :class="tab === 'beasiswa' ? 'bg-indigo-600 text-white shadow-sm' : 'text-slate-600 hover:bg-slate-50'" class="flex-1 text-center py-2.5 px-4 rounded-lg text-xs font-semibold uppercase tracking-wider transition-all duration-150">
            6. Beasiswa
        </button>
    </div>

    <form action="{{ route('data-diri.update') }}" method="POST" class="space-y-6 text-sm" novalidate>
        @csrf
        @method('PUT')

        @if ($errors->any())
        <div class="mx-6 mt-6 p-4 bg-rose-50 border border-rose-150 text-rose-900 rounded-xl text-xs flex items-start gap-3 shadow-sm animate-fade-in">
            <div class="w-6 h-6 rounded-md bg-rose-500 text-white flex items-center justify-center shrink-0 font-bold">
                !
            </div>
            <div>
                <h4 class="font-bold text-rose-900 mb-1">Gagal menyimpan data! Periksa kembali isian Anda:</h4>
                <ul class="list-disc ml-4 space-y-0.5 text-rose-700">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <input type="hidden" name="tab" x-model="tab">

        <div x-show="tab === 'pribadi'" class="bg-white rounded-2xl border border-slate-100 p-6 space-y-4 shadow-sm" x-transition>
            <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">Bagian I: Biodata Pribadi Calon Siswa</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">1. Nama Lengkap (Sesuai Akta/Ijazah) *</label>
                    <input type="text" name="nama_lengkap" required value="{{ old('nama_lengkap', $peserta->nama_lengkap ?? $peserta->nama) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 transition">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">2. Jenis Kelamin *</label>
                    <select name="jenis_kelamin" required class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:border-indigo-500 transition">
                        <option value="Laki-laki" {{ old('jenis_kelamin', $peserta->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $peserta->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">3. NISN (10 Digit) *</label>
                    <input type="text" name="nisn" required value="{{ old('nisn', $peserta->nisn) }}" placeholder="Contoh: 0009321234" maxlength="10" class="w-full px-4 py-2 border border-slate-200 rounded-xl font-mono">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">4. NIK / KITAS (WNA) *</label>
                    <input type="text" name="nik" required value="{{ old('nik', $peserta->nik) }}" maxlength="16" class="w-full px-4 py-2 border border-slate-200 rounded-xl font-mono">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">5. No. Kartu Keluarga (KK) *</label>
                    <input type="text" name="no_kk" required value="{{ old('no_kk', $peserta->no_kk) }}" maxlength="16" class="w-full px-4 py-2 border border-slate-200 rounded-xl font-mono">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">6. Tempat Lahir *</label>
                    <input type="text" name="tempat_lahir" required value="{{ old('tempat_lahir', $peserta->tempat_lahir) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">7. Tanggal Lahir *</label>
                    <input type="date"
                        name="tanggal_lahir"
                        required
                        value="{{ old('tanggal_lahir', isset($peserta->tanggal_lahir) ? \Carbon\Carbon::parse($peserta->tanggal_lahir)->format('Y-m-d') : '') }}"
                        class="w-full px-4 py-2 border border-slate-200 rounded-xl @error('tanggal_lahir') border-red-500 @enderror">
                    @error('tanggal_lahir')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">8. No. Registrasi Akta Lahir</label>
                    <input type="text" name="no_registrasi_akta" value="{{ old('no_registrasi_akta', $peserta->no_registrasi_akta) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>

                <div>
                    <label class="block text-slate-600 font-medium mb-1">9. Agama & Kepercayaan *</label>
                    <select name="agama" required class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        @foreach(['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu', 'Kepercayaan Kepada Tuhan YME'] as $agama)
                        <option value="{{ $agama }}" {{ old('agama', $peserta->agama) == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">10. Jalur Pendaftaran *</label>
                    <select name="jalur_pendaftaran" required class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="">-- Pilih Jalur Pendaftaran --</option>
                        @foreach([
                        'Mutasi Anak Guru',
                        'Afirmasi KETM',
                        'Proiritas Terdekat',
                        'AKD Persiapan Kelas Industri',
                        'Non AKD Kejuruan',
                        'AKD Rapot',
                        'Non AKD Kepemimpinan',
                        'AKD Kejuruan'
                        ] as $item)
                        <option value="{{ $item }}" {{ old('jalur_pendaftaran', $peserta->jalur_pendaftaran ?? '') == $item ? 'selected' : '' }}>
                            {{ $item }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-slate-600 font-medium mb-1">11. Kompetensi Keahlian Jurusan *</label>
                    <select name="kompetensi_keahlian" required class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
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
                        <option value="{{ $jurusan }}" {{ old('kompetensi_keahlian', $peserta->kompetensi_keahlian ?? '') == $jurusan ? 'selected' : '' }}>
                            {{ $jurusan }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">12. Kewarganegaraan</label>
                    <select name="kewarganegaraan" x-model="kwn" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="WNI">Indonesia (WNI)</option>
                        <option value="WNA">Asing (WNA)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">13. Nama Negara Asal</label>
                    <input type="text" name="negara_asal" value="{{ old('negara_asal', $peserta->negara_asal) }}" placeholder="Kosongkan jika WNI" class="w-full px-4 py-2 border border-slate-200 rounded-xl" :disabled="kwn === 'WNI'">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-3">
                    <label class="block text-slate-600 font-medium mb-2">14. Berkebutuhan Khusus</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 p-4 bg-slate-50 border border-slate-200 rounded-xl">
                        @php
                        $bk_saved = is_array($peserta->berkebutuhan_khusus) ? $peserta->berkebutuhan_khusus : json_decode($peserta->berkebutuhan_khusus, true) ?? [];
                        @endphp
                        @foreach([
                        'Tidak' => 'Tidak Ada', 'Netra' => 'A - Netra', 'Rungu' => 'B - Rungu', 'Grahita Ringan' => 'C - Grahita Ringan',
                        'Grahita Sedang' => 'C1 - Grahita Sedang', 'Daksa Ringan' => 'D - Daksa Ringan', 'Daksa Sedang' => 'D1 - Daksa Sedang',
                        'Laras' => 'E - Laras', 'Wicara' => 'F - Wicara', 'Tuna Ganda' => 'G - Tuna Ganda', 'Hiperaktif' => 'H - Hiperaktif',
                        'Cerdas Istimewa' => 'I - Cerdas Istimewa', 'Bakat Istimewa' => 'J - Bakat Istimewa', 'Kesulitan Belajar' => 'K - Kesulitan Belajar',
                        'Narkoba' => 'N - Korban Narkoba', 'Indigo' => 'O - Indigo', 'Down Syndrome' => 'P - Down Syndrome', 'Autis' => 'Q - Autis'
                        ] as $value => $label)
                        <label class="flex items-start gap-2 bg-white p-2.5 rounded-lg border border-slate-200 shadow-sm cursor-pointer hover:bg-slate-100/50 transition">
                            <input type="checkbox" name="berkebutuhan_khusus[]" value="{{ $value }}"
                                {{ (is_array(old('berkebutuhan_khusus', $bk_saved)) && in_array($value, old('berkebutuhan_khusus', $bk_saved))) ? 'checked' : '' }}
                                class="mt-0.5 w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-xs text-slate-700 font-medium">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-slate-600 font-medium mb-1">15. Alamat Jalan / Perumahan / No. Rumah</label>
                <textarea name="alamat" rows="2" class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 transition">{{ old('alamat', $peserta->alamat) }}</textarea>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">16. Provinsi <span class="text-red-500">*</span></label>
                    <select id="provinsi" name="provinsi" required class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white focus:ring-2 focus:ring-indigo-500">
                        <option value="">Pilih Provinsi</option>
                        @if(!empty($peserta->provinsi))
                        <option value="{{ $peserta->provinsi }}" selected>{{ $peserta->provinsi }}</option>
                        @endif
                    </select>
                </div>

                <div>
                    <label class="block text-slate-600 font-medium mb-1">17. Kabupaten/Kota <span class="text-red-500">*</span></label>
                    <select id="kabupaten" name="kabupaten" required class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white focus:ring-2 focus:ring-indigo-500" {{ empty($peserta->kabupaten) ? 'disabled' : '' }}>
                        <option value="">Pilih Kabupaten/Kota</option>
                        @if(!empty($peserta->kabupaten))
                        <option value="{{ $peserta->kabupaten }}" selected>{{ $peserta->kabupaten }}</option>
                        @endif
                    </select>
                </div>

                <div>
                    <label class="block text-slate-600 font-medium mb-1">18. Kecamatan <span class="text-red-500">*</span></label>
                    <select id="kecamatan" name="kecamatan" required class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white focus:ring-2 focus:ring-indigo-500" {{ empty($peserta->kecamatan) ? 'disabled' : '' }}>
                        <option value="">Pilih Kecamatan</option>
                        @if(!empty($peserta->kecamatan))
                        <option value="{{ $peserta->kecamatan }}" selected>{{ $peserta->kecamatan }}</option>
                        @endif
                    </select>
                </div>

                <div>
                    <label class="block text-slate-600 font-medium mb-1">19. Desa / Kelurahan <span class="text-red-500">*</span></label>
                    <select id="desa_kelurahan" name="desa_kelurahan" required class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white focus:ring-2 focus:ring-indigo-500" {{ empty($peserta->desa_kelurahan) ? 'disabled' : '' }}>
                        <option value="">Pilih Desa/Kelurahan</option>
                        @if(!empty($peserta->desa_kelurahan))
                        <option value="{{ $peserta->desa_kelurahan }}" selected>{{ $peserta->desa_kelurahan }}</option>
                        @endif
                    </select>
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">20. Nama Dusun / Kampung</label>
                    <input type="text" name="dusun" value="{{ old('dusun', $peserta->dusun) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">21. RT</label>
                    <input type="text" name="rt" value="{{ old('rt', $peserta->rt) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl font-mono">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">22. RW</label>
                    <input type="text" name="rw" value="{{ old('rw', $peserta->rw) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl font-mono">
                </div>

                <div>
                    <label class="block text-slate-600 font-medium mb-1">23. Kode Pos</label>
                    <input type="text" name="kode_pos" value="{{ old('kode_pos', $peserta->kode_pos) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl font-mono">
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">24. Koordinat Lintang</label>
                    <input type="text" name="lintang" value="{{ old('lintang', $peserta->lintang) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">25. Koordinat Bujur</label>
                    <input type="text" name="bujur" value="{{ old('bujur', $peserta->bujur) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">26. Tempat Tinggal</label>
                    <select name="tempat_tinggal" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        @foreach(['Bersama Orang Tua', 'Wali', 'Kos', 'Asrama', 'Panti Asuhan'] as $tt)
                        <option value="{{ $tt }}" {{ old('tempat_tinggal', $peserta->tempat_tinggal) == $tt ? 'selected' : '' }}>{{ $tt }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">27. Moda Transportasi</label>
                    <select name="moda_transportasi" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        @foreach(['Jalan Kaki', 'Kendaraan Pribadi', 'Kendaraan Umum', 'Jemputan Sekolah', 'Kereta Api', 'Ojek', 'Lainnya'] as $trans)
                        <option value="{{ $trans }}" {{ old('moda_transportasi', $peserta->moda_transportasi) == $trans ? 'selected' : '' }}>{{ $trans }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 pt-2">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">28. Anak Keberapa (di KK)</label>
                    <input type="number" name="anak_ke" value="{{ old('anak_ke', $peserta->anak_ke) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">29. Pekerjaan </label>
                    <select name="pekerjaan_siswa" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach(['Tidak Bekerja', 'Nelayan', 'Petani', 'Buruh', 'Lainnya'] as $pekerjaan_siswa)
                        <option value="{{ $pekerjaan_siswa }}" {{ old('pekerjaan_siswa', $peserta->pekerjaan_siswa) == $pekerjaan_siswa ? 'selected' : '' }}>{{ $pekerjaan_siswa }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center pt-5">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="punya_kip" value="1" {{ old('punya_kip', $peserta->punya_kip) == '1' ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-indigo-600">
                        <span class="text-slate-700 font-medium text-xs">30. Memiliki Kartu KIP fisik?</span>
                    </label>
                </div>
                <div class="flex items-center pt-5">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="penerima_kip" value="1" {{ old('penerima_kip', $peserta->penerima_kip) == '1' ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-indigo-600">
                        <span class="text-slate-700 font-medium text-xs">31. Tetap menerima bantuan KIP?</span>
                    </label>
                </div>
            </div>
        </div>

        <div x-show="tab === 'ayah'" class="bg-white rounded-2xl border border-slate-100 p-6 space-y-4 shadow-sm" x-transition>
            <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">Bagian II: Data Ayah Kandung</h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">27. Nama Ayah Kandung</label>
                    <input type="text" name="nama_ayah" value="{{ old('nama_ayah', $peserta->nama_ayah) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">28. NIK Ayah</label>
                    <input type="text" name="nik_ayah" value="{{ old('nik_ayah', $peserta->nik_ayah) }}" maxlength="16" class="w-full px-4 py-2 border border-slate-200 rounded-xl font-mono">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">29. Tahun Lahir Ayah</label>
                    <input type="number" name="tahun_lahir_ayah" value="{{ old('tahun_lahir_ayah', $peserta->tahun_lahir_ayah) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">30. Pendidikan Terakhir</label>
                    <select name="pendidikan_ayah" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="">-- Pilih Pendidikan --</option>
                        @foreach(['Tidak Sekolah', 'SD/Sederajat', 'SMP/Sederajat', 'SMA/Sederajat', 'D4/S1', 'S2', 'S3'] as $p)
                        <option value="{{ $p }}" {{ old('pendidikan_ayah', $peserta->pendidikan_ayah) == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">31. Pekerjaan Utama</label>
                    <select name="pekerjaan_ayah" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach(['Tidak Bekerja', 'Nelayan', 'Petani', 'PNS/TNI/POLRI', 'Karyawan Swasta', 'Wiraswasta', 'Buruh', 'Meninggal Dunia'] as $peka)
                        <option value="{{ $peka }}" {{ old('pekerjaan_ayah', $peserta->pekerjaan_ayah) == $peka ? 'selected' : '' }}>{{ $peka }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">32. Penghasilan Bulanan</label>
                    <select name="penghasilan_ayah" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="">-- Pilih Rentang --</option>
                        @foreach(['< 500.000'=> '< Rp. 500.000', '500.000 - 999.999'=> 'Rp. 500.000 - Rp. 999.999', '1.000.000 - 1.999.999' => 'Rp. 1.000.000 - Rp. 1.999.999', '2.000.000 - 4.999.999' => 'Rp. 2.000.000 - Rp. 4.999.999', 'Tidak Berpenghasilan' => 'Tidak Berpenghasilan'] as $val => $text)
                                <option value="{{ $val }}" {{ old('penghasilan_ayah', $peserta->penghasilan_ayah) == $val ? 'selected' : '' }}>{{ $text }}</option>
                                @endforeach
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">33. Berkebutuhan Khusus Ayah</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 p-4 bg-slate-50 border border-slate-200 rounded-xl">
                        @php $bka_saved = is_array($peserta->kebutuhan_khusus_ayah) ? $peserta->kebutuhan_khusus_ayah : json_decode($peserta->kebutuhan_khusus_ayah, true) ?? []; @endphp
                        @foreach(['Tidak', 'Netra (A)', 'Rungu (B)', 'Grahita Ringan (C)', 'Grahita Sedang (C1)', 'Daksa Ringan (D)', 'Daksa Sedang (D1)', 'Laras (E)', 'Wicara (F)', 'Tuna Ganda (G)', 'Hiperaktif (H)', 'Cerdas Istimewa (I)', 'Bakat Istimewa (J)', 'Kesulitan Belajar (K)', 'Indigo (L)', 'Autis (M)', 'Down Syndrome (N)', 'Lainnya'] as $value => $label)
                        <label class="flex items-start gap-2 bg-white p-2.5 rounded-lg border border-slate-200 shadow-sm cursor-pointer hover:bg-slate-100/50 transition">
                            <input type="checkbox" name="kebutuhan_khusus_ayah[]" value="{{ $value }}"
                                {{ (is_array(old('kebutuhan_khusus_ayah', $bka_saved)) && in_array($value, old('kebutuhan_khusus_ayah', $bka_saved))) ? 'checked' : '' }}
                                class="mt-0.5 w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-xs text-slate-700 font-medium">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div x-show="tab === 'ibu'" class="bg-white rounded-2xl border border-slate-100 p-6 space-y-4 shadow-sm" x-transition>
            <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">Bagian III: Data Ibu Kandung</h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">34. Nama Ibu Kandung</label>
                    <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $peserta->nama_ibu) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">35. NIK Ibu</label>
                    <input type="text" name="nik_ibu" value="{{ old('nik_ibu', $peserta->nik_ibu) }}" maxlength="16" class="w-full px-4 py-2 border border-slate-200 rounded-xl font-mono">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">36. Tahun Lahir Ibu</label>
                    <input type="number" name="tahun_lahir_ibu" value="{{ old('tahun_lahir_ibu', $peserta->tahun_lahir_ibu) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">37. Pendidikan Terakhir</label>
                    <select name="pendidikan_ibu" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="">-- Pilih Pendidikan --</option>
                        @foreach(['Tidak Sekolah', 'SD/Sederajat', 'SMP/Sederajat', 'SMA/Sederajat', 'D4/S1'] as $p)
                        <option value="{{ $p }}" {{ old('pendidikan_ibu', $peserta->pendidikan_ibu) == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">38. Pekerjaan Utama</label>
                    <select name="pekerjaan_ibu" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach(['Tidak Bekerja', 'Nelayan', 'Petani', 'Karyawan Swasta', 'Wiraswasta', 'Meninggal Dunia'] as $peki)
                        <option value="{{ $peki }}" {{ old('pekerjaan_ibu', $peserta->pekerjaan_ibu) == $peki ? 'selected' : '' }}>{{ $peki }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">39. Penghasilan Bulanan Ibu</label>
                    <select name="penghasilan_ibu" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="">-- Pilih Rentang --</option>
                        @foreach(['< 500.000'=> '< Rp. 500.000', '500.000 - 999.999'=> 'Rp. 500.000 - Rp. 999.999', 'Tidak Berpenghasilan' => 'Tidak Berpenghasilan'] as $val => $text)
                                <option value="{{ $val }}" {{ old('penghasilan_ibu', $peserta->penghasilan_ibu) == $val ? 'selected' : '' }}>{{ $text }}</option>
                                @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">40. Berkebutuhan Khusus Ibu</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 p-4 bg-slate-50 border border-slate-200 rounded-xl">
                        @php $bki_saved = is_array($peserta->kebutuhan_khusus_ibu) ? $peserta->kebutuhan_khusus_ibu : json_decode($peserta->kebutuhan_khusus_ibu, true) ?? []; @endphp
                        @foreach(['Tidak', 'Netra (A)', 'Rungu (B)', 'Grahita Ringan (C)', 'Grahita Sedang (C1)', 'Daksa Ringan (D)', 'Daksa Sedang (D1)', 'Laras (E)', 'Wicara (F)', 'Tuna Ganda (G)', 'Hiperaktif (H)', 'Cerdas Istimewa (I)', 'Bakat Istimewa (J)', 'Kesulitan Belajar (K)', 'Indigo (L)', 'Autis (M)', 'Down Syndrome (N)', 'Lainnya'] as $value => $label)
                        <label class="flex items-start gap-2 bg-white p-2.5 rounded-lg border border-slate-200 shadow-sm cursor-pointer hover:bg-slate-100/50 transition">
                            <input type="checkbox" name="kebutuhan_khusus_ibu[]" value="{{ $value }}"
                                {{ (is_array(old('kebutuhan_khusus_ibu', $bki_saved)) && in_array($value, old('kebutuhan_khusus_ibu', $bki_saved))) ? 'checked' : '' }}
                                class="mt-0.5 w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                            <span class="text-xs text-slate-700 font-medium">{{ $label }}</span>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div x-show="tab === 'wali'" class="bg-white rounded-2xl border border-slate-100 p-6 space-y-4 shadow-sm" x-transition>
            <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-2 mb-2">Bagian IV: Data Wali (Ayah/Ibu Sambung jika Ada)</h3>
            <p class="text-xs text-slate-400 mb-4">*Kosongkan jika siswa masih tinggal bersama orang tua kandung.</p>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">41. Nama Wali</label>
                    <input type="text" name="nama_wali" value="{{ old('nama_wali', $peserta->nama_wali) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">42. NIK Wali</label>
                    <input type="text" name="nik_wali" value="{{ old('nik_wali', $peserta->nik_wali) }}" maxlength="16" class="w-full px-4 py-2 border border-slate-200 rounded-xl font-mono">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">43. Tahun Lahir Wali</label>
                    <input type="number" name="tahun_lahir_wali" value="{{ old('tahun_lahir_wali', $peserta->tahun_lahir_wali) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">44. Pendidikan Wali</label>
                    <select name="pendidikan_wali" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="">-- Pilih Pendidikan --</option>
                        @foreach(['Tidak Sekolah', 'SD/Sederajat', 'SMP/Sederajat', 'SMA/Sederajat', 'D4/S1'] as $p)
                        <option value="{{ $p }}" {{ old('pendidikan_wali', $peserta->pendidikan_wali) == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">45. Pekerjaan Wali</label>
                    <select name="pekerjaan_wali" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach(['Tidak Bekerja', 'Nelayan', 'Petani', 'Karyawan Swasta', 'Wiraswasta'] as $pekw)
                        <option value="{{ $pekw }}" {{ old('pekerjaan_wali', $peserta->pekerjaan_wali) == $pekw ? 'selected' : '' }}>{{ $pekw }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">46. Penghasilan Bulanan Wali</label>
                    <select name="penghasilan_wali" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white shadow-sm">
                        <option value="">-- Pilih Rentang --</option>
                        @foreach(['< 500.000'=> '< Rp. 500.000', '1.000.000 - 1.999.999'=> 'Rp. 1.000.000 - Rp. 1.999.999', 'Tidak Berpenghasilan' => 'Tidak Berpenghasilan'] as $val => $text)
                                <option value="{{ $val }}" {{ old('penghasilan_wali', $peserta->penghasilan_wali) == $val ? 'selected' : '' }}>{{ $text }}</option>
                                @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div x-show="tab === 'kontak'" class="bg-white rounded-2xl border border-slate-100 p-6 space-y-4 shadow-sm" x-transition>
            <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">Bagian V: Kontak & Rincian Data</h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">47. No. HP Rumah / Orang Tua</label>
                    <input type="text" name="no_hp_ortu" value="{{ old('no_hp_ortu', $peserta->no_hp_ortu) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">48. No. HP Utama Siswa</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $peserta->no_hp) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">49. Alamat Email Aktif</label>
                    <input type="email" name="email" value="{{ old('email', $peserta->email) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
            </div>

            <h4 class="text-xs font-bold text-indigo-600 uppercase tracking-wider pt-4 border-t border-dashed border-slate-100">DATA PERIODIK</h4>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">Tinggi Badan (cm)</label>
                    <input type="number" name="tinggi_badan" value="{{ old('tinggi_badan', $peserta->tinggi_badan) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">Berat Badan (kg)</label>
                    <input type="number" name="berat_badan" value="{{ old('berat_badan', $peserta->berat_badan) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">Jarak Rumah ke Sekolah</label>
                    <select name="jarak_sekolah" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="Kurang dari 1 km" {{ old('jarak_sekolah', $peserta->jarak_sekolah) == 'Kurang dari 1 km' ? 'selected' : '' }}>Kurang dari 1 km</option>
                        <option value="Lebih dari 1 km" {{ old('jarak_sekolah', $peserta->jarak_sekolah) == 'Lebih dari 1 km' ? 'selected' : '' }}>Lebih dari 1 km</option>
                    </select>
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">Sebutkan (dalam kilometer)</label>
                    <input type="number" name="jarak_kilometer" value="{{ old('jarak_kilometer', $peserta->jarak_kilometer) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">Waktu Tempuh (Menit)</label>
                    <input type="number" name="waktu_tempuh" value="{{ old('waktu_tempuh', $peserta->waktu_tempuh) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">Jumlah Saudara Kandung</label>
                    <input type="number" name="jumlah_saudara" value="{{ old('jumlah_saudara', $peserta->jumlah_saudara) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
            </div>

            <h4 class="text-xs font-bold text-indigo-600 uppercase tracking-wider pt-4 border-t border-dashed border-slate-100">KESEJAHTERAAN PESERTA DIDIK</h4>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">Jenis Kesejahteraan</label>
                    <select name="jenis_kesejahteraan" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="">-- Pilih Jenis Bantuan --</option>
                        @foreach(['PKH',
                        'PIP',
                        'Kartu Perlindungan Sosial',
                        'Kartu Keluarga Sejahtera',
                        'Kartu Kesehatan'] as $kes)
                        <option value="{{ $kes }}" {{ old('jenis_kesejahteraan', $peserta->jenis_kesejahteraan) == $kes ? 'selected' : '' }}>{{ $kes }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">Nama Di Kartu</label>
                    <input type="text" name="nama_pemegang_kartu" value="{{ old('nama_pemegang_kartu', $peserta->nama_pemegang_kartu) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">No Kartu</label>
                    <input type="text" name="nomor_kartu_kesejahteraan" value="{{ old('nomor_kartu_kesejahteraan', $peserta->nomor_kartu_kesejahteraan) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
            </div>
        </div>

        <div x-show="tab === 'beasiswa'" class="bg-white rounded-2xl border border-slate-100 p-6 space-y-4 shadow-sm" x-transition>
            <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">Bagian VI: Informasi Beasiswa (Jika Ada)</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">Jenis Beasiswa</label>
                    <select name="jenis_beasiswa" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="">-- Pilih Jenis Beasiswa --</option>
                        @foreach(['Anak Berprestasi', 'Anak Miskin', 'Pendidikan', 'Unggulan'] as $kes)
                        <option value="{{ $kes }}" {{ old('jenis_beasiswa', $peserta->jenis_beasiswa) == $kes ? 'selected' : '' }}>{{ $kes }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">Keterangan</label>
                    <input type="text" name="keterangan_beasiswa" value="{{ old('keterangan_beasiswa', $peserta->keterangan_beasiswa) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">Tahun Mulai</label>
                    <input type="text" name="tahun_mulai_beasiswa" value="{{ old('tahun_mulai_beasiswa', $peserta->tahun_mulai_beasiswa) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">Tahun Selesai</label>
                    <input type="text" name="tahun_selesai_beasiswa" value="{{ old('tahun_selesai_beasiswa', $peserta->tahun_selesai_beasiswa) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
            </div>
        </div>
        <div class="flex justify-between items-center pt-6 mt-6 border-t border-slate-100">
            <div>
                <button type="button"
                    x-show="tab !== tabs[0]"
                    @click="tab = tabs[tabs.indexOf(tab) - 1]; window.scrollTo({top: 0, behavior: 'smooth'})"
                    class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl text-sm transition shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali
                </button>
            </div>

            <div class="flex items-center gap-3">
                <button type="button"
                    x-show="tab !== tabs[tabs.length - 1]"
                    @click="tab = tabs[tabs.indexOf(tab) + 1]; window.scrollTo({top: 0, behavior: 'smooth'})"
                    class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-sm transition shadow-sm flex items-center gap-2">
                    Selanjutnya
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <button type="submit"
                    x-show="tab === tabs[tabs.length - 1]"
                    class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl text-sm transition shadow-md flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan Rekam Data
                </button>
            </div>
        </div>
    </form>
    @endif
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const provSelect = document.getElementById("provinsi");
        const kabSelect = document.getElementById("kabupaten");
        const kecSelect = document.getElementById("kecamatan");
        const desaSelect = document.getElementById("desa_kelurahan");

        // Ambil nilai lama dari database (disediakan oleh Blade)
        const oldProv = "{{ $peserta->provinsi ?? '' }}";
        const oldKab = "{{ $peserta->kabupaten ?? '' }}";
        const oldKec = "{{ $peserta->kecamatan ?? '' }}";
        const oldDesa = "{{ $peserta->desa_kelurahan ?? '' }}";

        // 1. Ambil Semua Provinsi
        fetch("https://ibnux.github.io/data-indonesia/provinsi.json")
            .then(res => res.json())
            .then(data => {
                provSelect.innerHTML = '<option value="">Pilih Provinsi</option>';
                data.forEach(prov => {
                    const selected = (prov.nama === oldProv) ? 'selected' : '';
                    provSelect.innerHTML += `<option value="${prov.nama}" data-id="${prov.id}" ${selected}>${prov.nama}</option>`;
                });

                // Jika ada data provinsi lama, otomatis panggil Kabupaten
                const activeProvId = provSelect.options[provSelect.selectedIndex]?.dataset.id;
                if (activeProvId) {
                    loadRegencies(activeProvId, oldKab);
                }
            });

        // 2. Fungsi Ambil Kabupaten
        function loadRegencies(provId, selectedValue = '') {
            fetch(`https://ibnux.github.io/data-indonesia/kabupaten/${provId}.json`)
                .then(res => res.json())
                .then(data => {
                    kabSelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
                    data.forEach(kab => {
                        const selected = (kab.nama === selectedValue) ? 'selected' : '';
                        kabSelect.innerHTML += `<option value="${kab.nama}" data-id="${kab.id}" ${selected}>${kab.nama}</option>`;
                    });
                    kabSelect.disabled = false;

                    // PERBAIKAN: Jalankan Kecamatan HANYA SETELAH Kabupaten selesai di-render
                    const activeKabId = kabSelect.options[kabSelect.selectedIndex]?.dataset.id;
                    if (activeKabId) {
                        loadDistricts(activeKabId, oldKec);
                    }
                });
        }

        // 3. Fungsi Ambil Kecamatan
        function loadDistricts(kabId, selectedValue = '') {
            fetch(`https://ibnux.github.io/data-indonesia/kecamatan/${kabId}.json`)
                .then(res => res.json())
                .then(data => {
                    kecSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                    data.forEach(kec => {
                        // PERBAIKAN: Gunakan kec.nama (bukan kec.name)
                        const selected = (kec.nama === selectedValue) ? 'selected' : '';
                        kecSelect.innerHTML += `<option value="${kec.nama}" data-id="${kec.id}" ${selected}>${kec.nama}</option>`;
                    });
                    kecSelect.disabled = false;

                    // PERBAIKAN: Jalankan Desa HANYA SETELAH Kecamatan selesai di-render
                    const activeKecId = kecSelect.options[kecSelect.selectedIndex]?.dataset.id;
                    if (activeKecId) {
                        loadVillages(activeKecId, oldDesa);
                    }
                });
        }

        // 4. Fungsi Ambil Desa / Kelurahan
        function loadVillages(kecId, selectedValue = '') {
            fetch(`https://ibnux.github.io/data-indonesia/kelurahan/${kecId}.json`)
                .then(res => res.json())
                .then(data => {
                    desaSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
                    data.forEach(desa => {
                        // PERBAIKAN: Gunakan desa.nama (bukan desa.name)
                        const selected = (desa.nama === selectedValue) ? 'selected' : '';
                        desaSelect.innerHTML += `<option value="${desa.nama}" data-id="${desa.id}" ${selected}>${desa.nama}</option>`;
                    });
                    desaSelect.disabled = false;
                });
        }

        // ==========================================
        // LISTENER EVENT UNTUK PERUBAHAN MANUAL USER
        // ==========================================
        provSelect.addEventListener("change", function() {
            kabSelect.innerHTML = '<option value=\"\">Pilih Kabupaten/Kota</option>';
            kecSelect.innerHTML = '<option value=\"\">Pilih Kecamatan</option>';
            desaSelect.innerHTML = '<option value=\"\">Pilih Desa/Kelurahan</option>';
            kabSelect.disabled = true;
            kecSelect.disabled = true;
            desaSelect.disabled = true;

            const provId = provSelect.options[provSelect.selectedIndex]?.dataset.id;
            if (provId) loadRegencies(provId);
        });

        kabSelect.addEventListener("change", function() {
            kecSelect.innerHTML = '<option value=\"\">Pilih Kecamatan</option>';
            desaSelect.innerHTML = '<option value=\"\">Pilih Desa/Kelurahan</option>';
            kecSelect.disabled = true;
            desaSelect.disabled = true;

            const kabId = kabSelect.options[kabSelect.selectedIndex]?.dataset.id;
            if (kabId) loadDistricts(kabId);
        });

        kecSelect.addEventListener("change", function() {
            desaSelect.innerHTML = '<option value=\"\">Pilih Desa/Kelurahan</option>';
            desaSelect.disabled = true;

            const kecId = kecSelect.options[kecSelect.selectedIndex]?.dataset.id;
            if (kecId) loadVillages(kecId);
        });
    });
</script>
@endsection