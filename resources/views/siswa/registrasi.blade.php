@extends('layouts.dashboard')

@section('title', 'Registrasi Mandiri')
@section('header_title', 'Registrasi Mandiri Peserta Didik')
@section('header_subtitle', 'Lengkapi data kompetensi keahlian beserta upload berkas scan lampiran pendaftaran fisik resmi.')

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- 1. KONDISI FORM TERKUNCI (DITERIMA / MENUNGGU VERIFIKASI) --}}
    @if($sudahRegistrasi)
    <div class="flex flex-col items-center justify-center min-h-[calc(100vh-160px)] w-full p-4 md:p-8 animate-fade-in bg-slate-50/50">
        <div class="bg-white p-6 md:p-10 rounded-2xl border border-slate-100 shadow-xl max-w-2xl w-full text-center">
            <div class="flex flex-col items-center gap-6">

                @if($registrasi && $registrasi->status_registrasi == 'Diterima')
                <div class="p-4 bg-emerald-50 rounded-full text-emerald-500 animate-bounce-short">
                    <svg class="w-16 h-16 md:w-20 md:h-20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800">Registrasi Anda Telah Diterima!</h3>
                <p class="text-slate-500 text-sm -mt-3">Selamat, berkas pendaftaran Anda telah diverifikasi dan dinyatakan sah oleh panitia SMK Negeri 1 Kawali.</p>

                {{-- TAMBAHAN FITUR: TOMBOL JOIN WHATSAPP JURUSAN --}}
                @php
                // Mapping 7 Jurusan dengan Link WhatsApp Masing-masing
                $waLinks = [
                'Teknik Otomotif' => 'https://chat.whatsapp.com/KZpsFLOgr3rCyQuLFMZTAI?s=cl&p=a&mlu=4',
                'Teknik Jaringan Komputer dan Telekomunikasi' => 'https://chat.whatsapp.com/DUYNo0kICvDCTemiu4MD49?s=cl&p=a&mlu=4',
                'Pengembangan Perangkat Lunak dan Gim' => 'https://chat.whatsapp.com/KfooiIZcSOw6mjSbdwXkq2?s=cl&p=a&mlu=4',
                'Desain Pemodelan dan Informasi Bangunan' => 'https://chat.whatsapp.com/JQNwR5nnbGAB7Ga0P2B0Uw?s=cl&p=a&mlu=4',
                'Manajemen Perkantoran dan Layanan Bisnis' => 'https://chat.whatsapp.com/CQYzWzIsjqA74L4VpfN4yB?s=cl&p=a&mlu=4',
                'Akuntansi dan Keuangan Lembaga' => 'https://chat.whatsapp.com/LRXHlJjDIFX8w85N9YsHcs?s=cl&p=a&mlu=4',
                'Seni Pertunjukan' => 'https://chat.whatsapp.com/I63QyKTlOdJAU9rKjOtCyr?s=cl&p=a&mlu=4'
                ];

                // Ambil jurusan dari model registrasi atau peserta didik
                $jurusanSiswa = $registrasi->kompetensi_keahlian ?? ($peserta->kompetensi_keahlian ?? null);
                $linkWaJurusan = $waLinks[$jurusanSiswa] ?? null;
                @endphp

                @if($linkWaJurusan)
                <div class="w-full mt-4 p-5 bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-100 rounded-xl flex flex-col items-center gap-3">
                    <div class="text-xs font-semibold text-emerald-800 uppercase tracking-wider">Grup Informasi Resmi Jurusan</div>
                    <div class="text-sm font-bold text-slate-700 -mt-1">{{ $jurusanSiswa }}</div>
                    <p class="text-xs text-slate-500 max-w-md">Silakan bergabung ke grup WhatsApp resmi kompetensi keahlian Anda untuk mendapatkan info herregistrasi dan masa orientasi.</p>

                    <a href="{{ $linkWaJurusan }}" target="_blank" rel="noopener noreferrer"
                        style="background-color: #25D366;"
                        class="inline-flex items-center gap-2 px-6 py-2.5 hover:bg-[#20ba56] text-white text-sm font-bold rounded-xl shadow-lg shadow-emerald-600/20 transition-all transform hover:-translate-y-0.5">
                        <!-- Icon WhatsApp (SVG) -->
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397 0 11.93 0c3.165.001 6.14 1.233 8.377 3.469 2.237 2.236 3.467 5.21 3.466 8.374-.003 6.582-5.338 11.93-11.871 11.93-2.003-.001-3.972-.51-5.712-1.48L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.725 1.451 5.416 0 9.825-4.41 9.827-9.827.001-2.624-1.022-5.09-2.885-6.956C16.42 1.956 13.95 .933 11.326.933c-5.42 0-9.83 4.41-9.832 9.829-.001 1.743.486 3.447 1.411 4.951l-.99 3.61 3.733-.979zM17.386 14.2c-.312-.156-1.847-.91-2.128-1.012-.282-.102-.487-.156-.692.156-.204.311-.79.156-.968.102a.792.792 0 0 1-.225-.138c-.32-.16-.685-.386-.983-.645-.298-.258-.535-.515-.656-.723-.122-.208-.013-.321.092-.425.094-.094.204-.24.306-.359.103-.12.137-.203.205-.339.068-.135.034-.254-.017-.359-.051-.104-.487-1.173-.667-1.606-.176-.423-.351-.365-.487-.372-.126-.006-.271-.007-.417-.007-.146 0-.384.055-.585.274-.201.218-.767.749-.767 1.826 0 1.077.784 2.116.893 2.262.11.146 1.543 2.356 3.739 3.303.522.226.93.361 1.248.463.525.166 1.002.143 1.379.086.42-.063 1.288-.526 1.469-1.033.181-.506.181-.941.127-1.033-.054-.092-.203-.139-.515-.295z" />
                        </svg>
                        Gabung ke Grup WhatsApp
                    </a>
                </div>
                @endif

                @else
                <div class="p-4 bg-amber-50 rounded-full text-amber-500 animate-bounce-short">
                    <svg class="w-16 h-16 md:w-20 md:h-20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800">Berkas Menunggu Verifikasi</h3>
                <p class="text-slate-500 text-sm -mt-3">Anda telah melakukan registrasi mandiri. Data Anda saat ini sedang dikunci untuk proses pemeriksaan oleh operator sekolah.</p>
                @endif

            </div>
        </div>
    </div>

    {{-- 2. KONDISI FORM TERBUKA (BELUM DAFTAR ATAU STATUS DITOLAK) --}}
    @else

    {{-- Jika statusnya ditolak, tampilkan Alert Peringatan di atas Form --}}
    @if($registrasi && $registrasi->status_registrasi == 'Ditolak')
    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-100 text-rose-900 text-sm flex items-start gap-3 shadow-sm mb-6 animate-fade-in">
        <div class="w-8 h-8 rounded-xl bg-rose-500 text-white flex items-center justify-center shrink-0 shadow-md shadow-rose-500/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <h4 class="font-bold text-rose-900">Registrasi Ditolak / Memerlukan Perbaikan</h4>
            <p class="text-rose-700/90 text-xs mt-0.5">Mohon maaf, berkas pendaftaran Anda sebelumnya ditolak oleh operator. Silakan periksa kembali berkas Anda, edit inputan data yang salah di bawah ini, dan kirim ulang formulir registrasi.</p>
        </div>
    </div>
    @endif
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