@extends('layouts.dashboard')

@section('title', 'Ubah Data Peserta')
@section('header_title', 'Edit Biodata Peserta')
@section('header_subtitle', 'Form pembaruan rekam data pendaftaran siswa sesuai dokumen Dapodik F-PD.')

@section('content')
<div class="max-w-5xl mx-auto" x-data="{
    tab: '{{ old('tab', 'pribadi') }}',
    kwn: '{{ old('kewarganegaraan', $peserta->kewarganegaraan ?? 'WNI') }}'
}">

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

    <form action="{{ route('data-peserta.update', $peserta->id) }}" method="POST" class="space-y-6 text-sm">
        @csrf
        @method('PUT')

        <input type="hidden" name="tab" x-model="tab">

        {{-- TAB 1: DATA PRIBADI --}}
        <div x-show="tab === 'pribadi'" class="bg-white rounded-2xl border border-slate-100 p-6 space-y-4 shadow-sm" x-transition>
            <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">Bagian I: Biodata Pribadi Calon Siswa</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-slate-600 font-medium mb-1">1. Nama Lengkap (Sesuai Akta/Ijazah)</label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $peserta->nama_lengkap) }}" required class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 transition">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">2. Jenis Kelamin</label>
                    <select name="jenis_kelamin" required class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white focus:outline-none focus:border-indigo-500 transition">
                        <option value="Laki-laki" {{ old('jenis_kelamin', $peserta->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $peserta->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">3. NISN (10 Digit)</label>
                    <input type="text" name="nisn" value="{{ old('nisn', $peserta->nisn) }}" placeholder="Contoh: 0009321234" maxlength="10" class="w-full px-4 py-2 border border-slate-200 rounded-xl font-mono">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">4. NIK / KITAS (WNA)</label>
                    <input type="text" name="nik" value="{{ old('nik', $peserta->nik) }}" required maxlength="16" class="w-full px-4 py-2 border border-slate-200 rounded-xl font-mono">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">5. No. Kartu Keluarga (KK)</label>
                    <input type="text" name="no_kk" value="{{ old('no_kk', $peserta->no_kk) }}" required maxlength="16" class="w-full px-4 py-2 border border-slate-200 rounded-xl font-mono">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">6. Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $peserta->tempat_lahir) }}" required class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">7. Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $peserta->tanggal_lahir ? \Carbon\Carbon::parse($peserta->tanggal_lahir)->format('Y-m-d') : '') }}" required class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">8. No. Registrasi Akta Lahir</label>
                    <input type="text" name="no_registrasi_akta" value="{{ old('no_registrasi_akta', $peserta->no_registrasi_akta) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">9. Agama & Kepercayaan</label>
                    <select name="agama" required class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        @foreach(['Islam', 'Kristen Protestan', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu', 'Kepercayaan Kepada Tuhan YME'] as $agama)
                        <option value="{{ $agama }}" {{ old('agama', $peserta->agama) == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">10. Kewarganegaraan</label>
                    <select name="kewarganegaraan" x-model="kwn" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="WNI">Indonesia (WNI)</option>
                        <option value="WNA">Asing (WNA)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">Nama Negara Asal</label>
                    <input type="text" name="negara_asal" value="{{ old('negara_asal', $peserta->negara_asal) }}" placeholder="Kosongkan jika WNI" class="w-full px-4 py-2 border border-slate-200 rounded-xl" :required="kwn === 'WNA'">
                </div>
            </div>

            <div class="grid grid-cols-1 gap-2 pt-2">
                <label class="block text-slate-600 font-medium mb-2">11. Berkebutuhan Khusus (Bisa Pilih Lebih Dari Satu)</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 p-4 bg-slate-50 border border-slate-200 rounded-xl">
                    @php
                    $currentKebutuhan = is_array($peserta->berkebutuhan_khusus)
                    ? $peserta->berkebutuhan_khusus
                    : json_decode($peserta->berkebutuhan_khusus, true) ?? [];
                    @endphp
                    @foreach([
                    'Tidak' => 'Tidak Ada',
                    'Netra' => 'A - Netra (Tunanetra)',
                    'Rungu' => 'B - Rungu (Tunarungu)',
                    'Grahita Ringan' => 'C - Grahita Ringan',
                    'Grahita Sedang' => 'C1 - Grahita Sedang',
                    'Daksa Ringan' => 'D - Daksa Ringan',
                    'Daksa Sedang' => 'D1 - Daksa Sedang',
                    'Laras' => 'E - Laras (Tunalaras)',
                    'Wicara' => 'F - Wicara',
                    'Tuna Ganda' => 'G - Tuna Ganda',
                    'Hiperaktif' => 'H - Hiperaktif',
                    'Cerdas Istimewa' => 'I - Cerdas Istimewa',
                    'Bakat Istimewa' => 'J - Bakat Istimewa',
                    'Kesulitan Belajar' => 'K - Kesulitan Belajar',
                    'Narkoba' => 'N - Korban Narkoba',
                    'Indigo' => 'O - Indigo',
                    'Down Syndrome' => 'P - Down Syndrome',
                    'Autis' => 'Q - Autis'
                    ] as $value => $label)
                    <label class="flex items-start gap-2 bg-white p-2.5 rounded-lg border border-slate-200 shadow-sm cursor-pointer hover:bg-slate-100/50 transition">
                        <input type="checkbox" name="berkebutuhan_khusus[]" value="{{ $value }}"
                            {{ in_array($value, old('berkebutuhan_khusus', $currentKebutuhan)) ? 'checked' : '' }}
                            class="mt-0.5 w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-xs text-slate-700 font-medium">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="block text-slate-600 font-medium mb-1">12. Alamat Jalan / Perumahan / No. Rumah</label>
                <textarea name="alamat" rows="2" required placeholder="Contoh: Jl. Kemanggisan, Komp Griya Adam, No 40" class="w-full px-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:border-indigo-500 transition">{{ old('alamat', $peserta->alamat) }}</textarea>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">13. RT</label>
                    <input type="text" name="rt" value="{{ old('rt', $peserta->rt) }}" placeholder="005" class="w-full px-4 py-2 border border-slate-200 rounded-xl font-mono">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">14. RW</label>
                    <input type="text" name="rw" value="{{ old('rw', $peserta->rw) }}" placeholder="011" class="w-full px-4 py-2 border border-slate-200 rounded-xl font-mono">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">15. Nama Dusun / Kampung</label>
                    <input type="text" name="dusun" value="{{ old('dusun', $peserta->dusun) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <label class="block text-slate-600 font-medium mb-1">16. Kelurahan/Desa</label>
                    <input type="text" name="desa_kelurahan" value="{{ old('desa_kelurahan', $peserta->desa_kelurahan) }}" required class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">17. Kecamatan</label>
                    <input type="text" name="kecamatan" value="{{ old('kecamatan', $peserta->kecamatan) }}" required class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">18. Kode Pos</label>
                    <input type="text" name="kode_pos" value="{{ old('kode_pos', $peserta->kode_pos) }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl font-mono">
                </div>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">19. Koordinat Lintang</label>
                    <input type="text" name="lintang" value="{{ old('lintang', $peserta->lintang) }}" placeholder="Contoh: -7.2132" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">20. Koordinat Bujur</label>
                    <input type="text" name="bujur" value="{{ old('bujur', $peserta->bujur) }}" placeholder="Contoh: 108.3121" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">21. Tempat Tinggal</label>
                    <select name="tempat_tinggal" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        @foreach(['Bersama Orang Tua', 'Wali', 'Kos', 'Asrama', 'Panti Asuhan'] as $tt)
                        <option value="{{ $tt }}" {{ old('tempat_tinggal', $peserta->tempat_tinggal) == $tt ? 'selected' : '' }}>{{ $tt }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">22. Moda Transportasi</label>
                    <select name="moda_transportasi" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        @foreach(['Jalan Kaki', 'Kendaraan Pribadi', 'Kendaraan Umum', 'Jemputan Sekolah', 'Kereta Api', 'Ojek', 'Andong/Bendi/Sado/Dokar/Delman/Beca', 'Perahu Penyeberangan/Rakit/Getek', 'Lainnya'] as $trans)
                        <option value="{{ $trans }}" {{ old('moda_transportasi', $peserta->moda_transportasi) == $trans ? 'selected' : '' }}>{{ $trans }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 pt-2">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">23. Anak Keberapa (di KK)</label>
                    <input type="number" name="anak_ke" value="{{ old('anak_ke', $peserta->anak_ke) }}" min="1" placeholder="1" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">24. Pekerjaan</label>
                    <select name="pekerjaan_siswa" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach([
                        'Tidak Bekerja',
                        'Nelayan',
                        'Petani',
                        'Peternak',
                        'PNS/TNI/POLRI',
                        'Karyawan Swasta',
                        'Pedagang Kecil',
                        'Pedagang Besar',
                        'Wiraswasta',
                        'Wirausaha',
                        'Buruh',
                        'Pensiunan'
                        ] as $pkr)
                        <option value="{{ $pkr }}" {{ old('pekerjaan_siswa', trim($peserta->pekerjaan_siswa)) == $pkr ? 'selected' : '' }}>
                            {{ $pkr }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center pt-5">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="punya_kip" value="1" {{ old('punya_kip', $peserta->punya_kip) == '1' ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-indigo-600">
                        <span class="text-slate-700 font-medium text-xs">25. Memiliki Kartu KIP fisik?</span>
                    </label>
                </div>
                <div class="flex items-center pt-5">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="penerima_kip" value="1" {{ old('penerima_kip', $peserta->penerima_kip) == '1' ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-indigo-600">
                        <span class="text-slate-700 font-medium text-xs">26. Tetap menerima bantuan KIP?</span>
                    </label>
                </div>
            </div>
        </div>

        {{-- TAB 2: DATA AYAH --}}
        <div x-show="tab === 'ayah'" class="bg-white rounded-2xl border border-slate-100 p-6 space-y-4 shadow-sm" x-transition>
            <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">Bagian II: Data Ayah Kandung</h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">27. Nama Ayah Kandung (Tanpa Gelar)</label>
                    <input type="text" name="nama_ayah" value="{{ old('nama_ayah', $peserta->nama_ayah) }}" placeholder="Hindari Alm, Dr, S.Pd, dll." class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">28. NIK Ayah</label>
                    <input type="text" name="nik_ayah" value="{{ old('nik_ayah', $peserta->nik_ayah) }}" maxlength="16" class="w-full px-4 py-2 border border-slate-200 rounded-xl font-mono">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">29. Tahun Lahir Ayah</label>
                    <input type="number" name="tahun_lahir_ayah" value="{{ old('tahun_lahir_ayah', $peserta->tahun_lahir_ayah) }}" placeholder="Contoh: 1978" max="{{ date('Y') }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">30. Pendidikan Terakhir</label>
                    <select name="pendidikan_ayah" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="">-- Pilih Pendidikan --</option>
                        @foreach(['Tidak Sekolah', 'Putus SD', 'SD/Sederajat', 'SMP/Sederajat', 'SMA/Sederajat', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3'] as $p)
                        <option value="{{ $p }}" {{ old('pendidikan_ayah', $peserta->pendidikan_ayah) == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">31. Pekerjaan Utama</label>
                    <select name="pekerjaan_ayah" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach(['Tidak Bekerja', 'Nelayan', 'Petani', 'Peternak', 'PNS/TNI/POLRI', 'Karyawan Swasta', 'Pedagang Kecil', 'Pedagang Besar', 'Wiraswasta', 'Wirausaha', 'Buruh', 'Pensiunan', 'Meninggal Dunia'] as $peka)
                        <option value="{{ $peka }}" {{ old('pekerjaan_ayah', $peserta->pekerjaan_ayah) == $peka ? 'selected' : '' }}>{{ $peka }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">32. Penghasilan Bulanan</label>
                    <select name="penghasilan_ayah" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="">-- Pilih Rentang --</option>
                        @foreach(['< 500.000'=> '< Rp. 500.000', '500.000 - 999.999'=> 'Rp. 500.000 - Rp. 999.999', '1.000.000 - 1.999.999' => 'Rp. 1.000.000 - Rp. 1.999.999', '2.000.000 - 4.999.999' => 'Rp. 2.000.000 - Rp. 4.999.999', '5.000.000 - 20.000.000' => 'Rp. 5.000.000 - Rp. 20.000.000', '> 20.000.000' => '> Rp. 20.000.000', 'Tidak Berpenghasilan' => 'Tidak Berpenghasilan'] as $val => $text)
                                <option value="{{ $val }}" {{ old('penghasilan_ayah', $peserta->penghasilan_ayah) == $val ? 'selected' : '' }}>{{ $text }}</option>
                                @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <label class="block text-slate-600 font-medium mb-1">33. Berkebutuhan Khusus Ayah</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 p-4 bg-slate-50 border border-slate-200 rounded-xl">
                    @foreach(['Tidak', 'Netra (A)', 'Rungu (B)', 'Grahita Ringan (C)', 'Grahita Sedang (C1)', 'Daksa Ringan (D)', 'Daksa Sedang (D1)', 'Laras (E)', 'Wicara (F)', 'Tuna Ganda (G)', 'Hiperaktif (H)', 'Cerdas Istimewa (I)', 'Bakat Istimewa (J)', 'Kesulitan Belajar (K)', 'Indigo (L)', 'Autis (M)', 'Down Syndrome (N)', 'Lainnya'] as $val)
                    <label class="flex items-start gap-2 bg-white p-2.5 rounded-lg border border-slate-200 shadow-sm cursor-pointer hover:bg-slate-100/50 transition">
                        <input type="checkbox"
                            name="kebutuhan_khusus_ayah[]"
                            value="{{ $val }}"
                            class="mt-0.5 w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                            {{ in_array($val, old('kebutuhan_khusus_ayah', is_array($peserta->kebutuhan_khusus_ayah) ? $peserta->kebutuhan_khusus_ayah : [])) ? 'checked' : '' }}>
                        <span class="text-xs text-slate-700 font-medium">{{ $val }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- TAB 3: DATA IBU --}}
        <div x-show="tab === 'ibu'" class="bg-white rounded-2xl border border-slate-100 p-6 space-y-4 shadow-sm" x-transition>
            <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">Bagian III: Data Ibu Kandung</h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">34. Nama Ibu Kandung (Tanpa Gelar)</label>
                    <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $peserta->nama_ibu) }}" placeholder="Sesuai dokumen KK, hindari gelar masehi/akademik" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">35. NIK Ibu</label>
                    <input type="text" name="nik_ibu" value="{{ old('nik_ibu', $peserta->nik_ibu) }}" maxlength="16" class="w-full px-4 py-2 border border-slate-200 rounded-xl font-mono">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">36. Tahun Lahir Ibu</label>
                    <input type="number" name="tahun_lahir_ibu" value="{{ old('tahun_lahir_ibu', $peserta->tahun_lahir_ibu) }}" placeholder="Contoh: 1982" max="{{ date('Y') }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">37. Pendidikan Terakhir Ibu</label>
                    <select name="pendidikan_ibu" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="">-- Pilih Pendidikan --</option>
                        @foreach(['Tidak Sekolah', 'Putus SD', 'SD/Sederajat', 'SMP/Sederajat', 'SMA/Sederajat', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3'] as $p)
                        <option value="{{ $p }}" {{ old('pendidikan_ibu', $peserta->pendidikan_ibu) == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">38. Pekerjaan Utama Ibu</label>
                    <select name="pekerjaan_ibu" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach(['Tidak Bekerja', 'Nelayan', 'Petani', 'Peternak', 'PNS/TNI/POLRI', 'Karyawan Swasta', 'Pedagang Kecil', 'Pedagang Besar', 'Wiraswasta', 'Wirausaha', 'Buruh', 'Pensiunan', 'Ibu Rumah Tangga', 'Meninggal Dunia'] as $peki)
                        <option value="{{ $peki }}" {{ old('pekerjaan_ibu', $peserta->pekerjaan_ibu) == $peki ? 'selected' : '' }}>{{ $peki }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">39. Penghasilan Bulanan Ibu</label>
                    <select name="penghasilan_ibu" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="">-- Pilih Rentang --</option>
                        @foreach(['< 500.000'=> '< Rp. 500.000', '500.000 - 999.999'=> 'Rp. 500.000 - Rp. 999.999', '1.000.000 - 1.999.999' => 'Rp. 1.000.000 - Rp. 1.999.999', '2.000.000 - 4.999.999' => 'Rp. 2.000.000 - Rp. 4.999.999', '5.000.000 - 20.000.000' => 'Rp. 5.000.000 - Rp. 20.000.000', '> 20.000.000' => '> Rp. 20.000.000', 'Tidak Berpenghasilan' => 'Tidak Berpenghasilan'] as $val => $text)
                                <option value="{{ $val }}" {{ old('penghasilan_ibu', $peserta->penghasilan_ibu) == $val ? 'selected' : '' }}>{{ $text }}</option>
                                @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4">
                <label class="block text-slate-600 font-medium mb-1">40. Berkebutuhan Khusus ibu</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 p-4 bg-slate-50 border border-slate-200 rounded-xl">
                    @foreach(['Tidak', 'Netra (A)', 'Rungu (B)', 'Grahita Ringan (C)', 'Grahita Sedang (C1)', 'Daksa Ringan (D)', 'Daksa Sedang (D1)', 'Laras (E)', 'Wicara (F)', 'Tuna Ganda (G)', 'Hiperaktif (H)', 'Cerdas Istimewa (I)', 'Bakat Istimewa (J)', 'Kesulitan Belajar (K)', 'Indigo (L)', 'Autis (M)', 'Down Syndrome (N)', 'Lainnya'] as $val)
                    <label class="flex items-start gap-2 bg-white p-2.5 rounded-lg border border-slate-200 shadow-sm cursor-pointer hover:bg-slate-100/50 transition">
                        <input type="checkbox"
                            name="kebutuhan_khusus_ibu[]"
                            value="{{ $val }}"
                            class="mt-0.5 w-4 h-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500"
                            {{ in_array($val, old('kebutuhan_khusus_ibu', is_array($peserta->kebutuhan_khusus_ibu) ? $peserta->kebutuhan_khusus_ibu : [])) ? 'checked' : '' }}>
                        <span class="text-xs text-slate-700 font-medium">{{ $val }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- TAB 4: DATA WALI --}}
        <div x-show="tab === 'wali'" class="bg-white rounded-2xl border border-slate-100 p-6 space-y-4 shadow-sm" x-transition>
            <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">Bagian IV: Data Wali (Opsional / Jika Ada)</h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">41. Nama Wali (Tanpa Gelar)</label>
                    <input type="text" name="nama_wali" value="{{ old('nama_wali', $peserta->nama_wali) }}" placeholder="Kosongkan jika tidak diwakilkan wali" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">42. NIK Wali</label>
                    <input type="text" name="nik_wali" value="{{ old('nik_wali', $peserta->nik_wali) }}" maxlength="16" class="w-full px-4 py-2 border border-slate-200 rounded-xl font-mono">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">43. Tahun Lahir Wali</label>
                    <input type="number" name="tahun_lahir_wali" value="{{ old('tahun_lahir_wali', $peserta->tahun_lahir_wali) }}" placeholder="Contoh: 1975" max="{{ date('Y') }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">44. Pendidikan Terakhir Wali</label>
                    <select name="pendidikan_wali" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="">-- Pilih Pendidikan --</option>
                        @foreach(['Tidak Sekolah', 'Putus SD', 'SD/Sederajat', 'SMP/Sederajat', 'SMA/Sederajat', 'D1', 'D2', 'D3', 'D4/S1', 'S2', 'S3'] as $p)
                        <option value="{{ $p }}" {{ old('pendidikan_wali', $peserta->pendidikan_wali) == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">45. Pekerjaan Utama Wali</label>
                    <select name="pekerjaan_wali" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="">-- Pilih Pekerjaan --</option>
                        @foreach(['Tidak Bekerja', 'Nelayan', 'Petani', 'Peternak', 'PNS/TNI/POLRI', 'Karyawan Swasta', 'Pedagang Kecil', 'Pedagang Besar', 'Wiraswasta', 'Wirausaha', 'Buruh', 'Pensiunan'] as $pekw)
                        <option value="{{ $pekw }}" {{ old('pekerjaan_wali', $peserta->pekerjaan_wali) == $pekw ? 'selected' : '' }}>{{ $pekw }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">46. Penghasilan Bulanan Wali</label>
                    <select name="penghasilan_wali" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="">-- Pilih Rentang --</option>
                        @foreach(['< 500.000'=> '< Rp. 500.000', '500.000 - 999.999'=> 'Rp. 500.000 - Rp. 999.999', '1.000.000 - 1.999.999' => 'Rp. 1.000.000 - Rp. 1.999.999', '2.000.000 - 4.999.999' => 'Rp. 2.000.000 - Rp. 4.999.999', '5.000.000 - 20.000.000' => 'Rp. 5.000.000 - Rp. 20.000.000', '> 20.000.000' => '> Rp. 20.000.000', 'Tidak Berpenghasilan' => 'Tidak Berpenghasilan'] as $val => $text)
                                <option value="{{ $val }}" {{ old('penghasilan_wali', $peserta->penghasilan_wali) == $val ? 'selected' : '' }}>{{ $text }}</option>
                                @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- TAB 5: KONTAK & PERIODIK --}}
        <div x-show="tab === 'kontak'" class="bg-white rounded-2xl border border-slate-100 p-6 space-y-4 shadow-sm" x-transition>
            <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">Bagian V: Kontak & Rincian Data Periodik</h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">47. Nomor HP Orang Tua / Rumah</label>
                    <input type="text" name="no_hp_ortu" value="{{ old('no_hp_ortu', $peserta->no_hp_ortu) }}" placeholder="Contoh: 081234567" class="w-full px-4 py-2 border border-slate-200 rounded-xl font-mono">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">48. Nomor HP Calon Siswa</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $peserta->no_hp) }}" placeholder="Contoh: 0889..." class="w-full px-4 py-2 border border-slate-200 rounded-xl font-mono">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">49. Alamat E-mail Aktif</label>
                    <input type="email" name="email" value="{{ old('email', $peserta->email) }}" placeholder="nama@gmail.com" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
            </div>

            <h4 class="text-xs font-bold text-indigo-600 uppercase tracking-wider pt-4 border-t border-dashed border-slate-100">DATA PERIODIK</h4>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-2">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">Tinggi Badan (Cm)</label>
                    <input type="number" name="tinggi_badan" value="{{ old('tinggi_badan', $peserta->tinggi_badan) }}" placeholder="165" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">Berat Badan (Kg)</label>
                    <input type="number" name="berat_badan" value="{{ old('berat_badan', $peserta->berat_badan) }}" placeholder="55" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">Jarak Tempat Tinggal</label>
                    <select name="jarak_sekolah" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="Kurang dari 1 km" {{ old('jarak_sekolah', $peserta->jarak_sekolah) == 'Kurang dari 1 km' ? 'selected' : '' }}>Kurang dari 1 km</option>
                        <option value="Lebih dari 1 km" {{ old('jarak_sekolah', $peserta->jarak_sekolah) == 'Lebih dari 1 km' ? 'selected' : '' }}>Lebih dari 1 km</option>
                    </select>
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">Detail Jarak (Kilometer)</label>
                    <input type="number" step="0.1" name="jarak_kilometer" value="{{ old('jarak_kilometer', $peserta->jarak_kilometer) }}" placeholder="Misal: 2.5" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">Waktu Tempuh Ke Sekolah (Menit)</label>
                    <input type="number" name="waktu_tempuh" value="{{ old('waktu_tempuh', $peserta->waktu_tempuh) }}" placeholder="Contoh: 15" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
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
                        <option value="">-- Pilih Jenis Kesejahteraan --</option>
                        @foreach(['PKH', 'PIP', 'KKS', 'KPS', 'Lainnya'] as $ksj)
                        <option value="{{ $ksj }}" {{ old('jenis_kesejahteraan', $peserta->jenis_kesejahteraan) == $ksj ? 'selected' : '' }}>
                            {{ $ksj }}
                        </option>
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

        {{-- TAB 6: DATA BEASISWA --}}
        <div x-show="tab === 'beasiswa'" class="bg-white rounded-2xl border border-slate-100 p-6 space-y-4 shadow-sm" x-transition>
            <h3 class="text-base font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">Bagian VI: Keterangan Beasiswa (Jika Ada)</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-slate-600 font-medium mb-1">Jenis Beasiswa</label>
                    <select name="jenis_beasiswa" value="{{ old('jenis_beasiswa') }}" class="w-full px-4 py-2 border border-slate-200 rounded-xl bg-white">
                        <option value="">-- Pilih Jenis Beasiswa --</option>
                        @foreach(['Anak berprestasi', 'Anak Miskin', 'Pendidikan', 'Unggulan'] as $kes)
                        <option value="{{ $kes }}" {{ old('jenis_beasiswa', $peserta->jenis_beasiswa) == $kes ? 'selected' : '' }}>{{ $kes }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-slate-600 font-medium mb-1">Keterangan / Sumber</label>
                    <input type="text" name="keterangan_beasiswa" value="{{ old('keterangan_beasiswa', $peserta->keterangan_beasiswa) }}" placeholder="Contoh: Pemerintah Daerah, Perusahaan Swasta" class="w-full px-4 py-2 border border-slate-200 rounded-xl">
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

            <div class="flex justify-between items-center bg-slate-50 border border-slate-100 p-4 rounded-xl mt-6">
                <div class="text-xs text-slate-400 font-medium">
                    * Tinjau kembali ke-6 tab sebelum melakukan penyimpanan perubahan biodata siswa.
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('data-peserta.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-50 font-medium transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-semibold shadow-md hover:bg-indigo-700 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection