<?php

namespace App\Http\Controllers\siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PesertaDidik;
use App\Models\RegistrasiPesertaDidik;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SiswaController extends Controller
{
    /**
     * Halaman Dashboard Siswa
     */
    public function index()
    {
        $user = Auth::user();

        $peserta = PesertaDidik::where('user_id', $user->id)->first();
        $registrasi = RegistrasiPesertaDidik::where('user_id', $user->id)->first();

        // PERBAIKAN: Hanya anggap TRUE jika data memang ada di tabel registrasi
        $sudahRegistrasi = $registrasi ? true : false;

        // Ambil status langsung dari baris registrasi, jika tidak ada set ke 'belum'
        $statusRegistrasi = $registrasi ? $registrasi->status_registrasi : 'belum';

        return view('siswa.dashboard', compact('peserta', 'sudahRegistrasi', 'statusRegistrasi', 'registrasi'));
    }

    /**
     * 1. Menampilkan data diri siswa yang sedang login (Tab 1 - 6)
     */
    public function dataDiri()
    {
        // Mencari data peserta didik yang terikat dengan user_id akun yang sedang login
        $peserta = PesertaDidik::where('user_id', Auth::id())->first();

        return view('siswa.data-diri.index', compact('peserta'));
    }

    public function EditDataDiri()
    {
        // Mencari data peserta didik yang terikat dengan user_id akun yang sedang login
        $peserta = PesertaDidik::where('user_id', Auth::id())->first();

        return view('siswa.data-diri.edit', compact('peserta'));
    }

    /**
     * 2. Proses update data diri (Menampung semua perubahan input dari data-diri.blade)
     */
    public function updateDataDiri(Request $request)
    {
        // Ambil data milik siswa yang sedang login berdasarkan nama tabel 'peserta_dieik'
        $peserta = PesertaDidik::where('user_id', Auth::id())->firstOrFail();

        // 1. OPSI PESAN KUSTOM: Supaya error tidak keluar tulisan 'validation.unique' lagi
        $messages = [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi pada Tab Data Diri.',
            'jenis_kelamin.required' => 'Jenis Kelamin wajib diisi.',
            'nisn.required' => 'NISN wajib diisi.',
            'nik.required' => 'NIK wajib diisi.',
            'no_kk.required' => 'NO KK wajib diisi.',
            'tempat_lahir.required' => 'Tempat Lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal Lahir wajib diisi.',
            'jalur_pendaftaran.required' => 'Jalur Pendaftaran wajib diisi.',
            'kompetensi_keahlian.required' => 'Kompetensi Keahlian wajib diisi.',
            'agama.required' => 'Agama wajib diisi.',
            'kewarganegaraan.required' => 'Kewarganegaraan wajib diisi.',
            'desa_kelurahan.required' => 'Dasa/Kelurahan wajib diisi.',
            'kecamatan.required' => 'Kecamatan wajib diisi.',
            'kabupaten.required' => 'Kabupaten wajib diisi.',
            'provinsi.required' => 'Provinsi wajib diisi.'
        ];

        // 2. LOGIKA VALIDASI: Menggunakan ignore ID (,$peserta->id) pada rule 'unique'
        $request->validate([
            // Bagian I: Pribadi
            'nama_lengkap'       => 'required|string|max:255',
            'jenis_kelamin'      => 'required|in:Laki-laki,Perempuan',

            // PENTING: Tambahkan 'unique:nama_tabel,nama_kolom,'.$peserta->id agar tidak bentrok saat update data sendiri
            'nisn'               => 'required|numeric|digits:10|unique:peserta_didik,nisn,' . $peserta->id,
            'nik'                => 'required|numeric|digits:16|unique:peserta_didik,nik,' . $peserta->id,
            'no_kk'              => 'required|numeric|digits:16',

            'tempat_lahir'       => 'required|string|max:255',
            'tanggal_lahir'      => 'required|date',
            'no_registrasi_akta' => 'nullable|string|max:255',
            'jalur_pendaftaran'  => 'required|string|max:255',
            'kompetensi_keahlian' => 'required|string|max:255',
            'agama'              => 'required|string',
            'kewarganegaraan'    => 'required|in:WNI,WNA',
            'negara_asal'        => 'required_if:kewarganegaraan,WNA|nullable|string|max:255',
            'berkebutuhan_khusus' => 'nullable|array',
            'alamat'             => 'nullable|string',
            'rt'                 => 'nullable|string|max:5',
            'rw'                 => 'nullable|string|max:5',
            'dusun'              => 'nullable|string|max:255',
            'desa_kelurahan'     => 'required|string|max:255',
            'kecamatan'          => 'required|string|max:255',
            'kabupaten'          => 'required|string|max:255',
            'provinsi'          => 'required|string|max:255',
            'kode_pos'           => 'nullable|string|max:10',
            'lintang'            => 'nullable|string|max:255',
            'bujur'              => 'nullable|string|max:255',
            'tempat_tinggal'     => 'nullable|string',
            'moda_transportasi'  => 'nullable|string',
            'anak_ke'            => 'nullable|integer|min:1',
            'pekerjaan_siswa'    => 'nullable|string',

            // Bagian II: Ayah
            'nama_ayah'            => 'nullable|string|max:255',
            'nik_ayah'             => 'nullable|numeric|digits:16',
            'tahun_lahir_ayah'     => 'nullable|integer',
            'pendidikan_ayah'      => 'nullable|string',
            'pekerjaan_ayah'       => 'nullable|string',
            'penghasilan_ayah'     => 'nullable|string',
            'kebutuhan_khusus_ayah' => 'nullable|array',

            // Bagian III: Ibu
            'nama_ibu'            => 'nullable|string|max:255',
            'nik_ibu'             => 'nullable|numeric|digits:16',
            'tahun_lahir_ibu'     => 'nullable|integer',
            'pendidikan_ibu'      => 'nullable|string',
            'pekerjaan_ibu'       => 'nullable|string',
            'penghasilan_ibu'     => 'nullable|string',
            'kebutuhan_khusus_ibu' => 'nullable|array',

            // Bagian IV: Wali
            'nama_wali'        => 'nullable|string|max:255',
            'nik_wali'         => 'nullable|numeric|digits:16',
            'tahun_lahir_wali' => 'nullable|integer',
            'pendidikan_wali'  => 'nullable|string',
            'pekerjaan_wali'   => 'nullable|string',
            'penghasilan_wali' => 'nullable|string',

            // Bagian V: Kontak & Periodik
            'no_hp_ortu'        => 'nullable|string|max:20',
            'no_hp'             => 'nullable|string|max:20',
            'email'             => 'nullable|email|max:255',
            'tinggi_badan'      => 'nullable|numeric',
            'berat_badan'       => 'nullable|numeric',
            'jarak_sekolah'     => 'nullable|string',
            'jarak_kilometer'   => 'nullable|numeric',
            'waktu_tempuh'      => 'nullable|integer',
            'jumlah_saudara'    => 'nullable|integer',
            'jenis_kesejahteraan' => 'nullable|string',
            'nama_pemegang_kartu' => 'nullable|string|max:255',
            'nomor_kartu_kesejahteraan' => 'nullable|string|max:255',

            // Bagian VI: Beasiswa
            'jenis_beasiswa'         => 'nullable|string',
            'keterangan_beasiswa'    => 'nullable|string',
            'tahun_mulai_beasiswa'   => 'nullable|string|max:4',
            'tahun_selesai_beasiswa' => 'nullable|string|max:4',
        ], $messages); // Menyertakan kustom pesan bahasa indonesia

        $data = $request->all();

        // Konversi nilai checkbox pendukung agar singkron dengan database
        $data['punya_kip'] = $request->has('punya_kip') ? 1 : 0;
        $data['penerima_kip'] = $request->has('penerima_kip') ? 1 : 0;

        // Pastikan array checkbox dirubah menjadi JSON / otomatis dicasting oleh Model PesertaDidik
        $data['berkebutuhan_khusus'] = $request->has('berkebutuhan_khusus') ? $request->berkebutuhan_khusus : null;
        $data['kebutuhan_khusus_ayah'] = $request->has('kebutuhan_khusus_ayah') ? $request->kebutuhan_khusus_ayah : null;
        $data['kebutuhan_khusus_ibu'] = $request->has('kebutuhan_khusus_ibu') ? $request->kebutuhan_khusus_ibu : null;

        // Eksekusi Update ke Database
        $peserta->update($data);

        return redirect()->route('registrasi.siswa')
            ->with('success', 'Data diri berhasil diperbarui!')
            ->withInput(['tab' => $request->tab]);
    }

    /**
     * 3. Halaman registrasi mandiri oleh siswa
     */
    public function registrasi()
    {
        $user = Auth::user();

        $peserta = PesertaDidik::where('user_id', $user->id)->first();
        $registrasi = RegistrasiPesertaDidik::where('user_id', $user->id)->first();

        $sudahRegistrasi = false;

        // VALIDASI ASLI: Hanya anggap sudah registrasi jika datanya MEMANG ADA di tabel registrasi
        if ($registrasi) {
            if ($registrasi->status_registrasi == 'Menunggu Verifikasi' || $registrasi->status_registrasi == 'Diterima') {
                $sudahRegistrasi = true;
            }
        }

        return view('siswa.registrasi', compact('peserta', 'registrasi', 'sudahRegistrasi'));
    }

    /**
     * 4. Proses simpan registrasi mandiri beserta upload berkas lampiran
     */
    public function storeRegistrasi(Request $request)
    {
        $user = Auth::user();
        $customMessages = [
            'max' => 'Ukuran file :attribute melebihi 2MB. Silakan kompres terlebih dahulu sebelum diunggah.',
            'mimes' => 'Format file :attribute harus berupa PDF, JPG, JPEG, atau PNG.'
        ];

        $customAttributes = [
            'kk' => 'Kartu Keluarga (KK)',
            'ktp_ortu' => 'KTP Orang Tua',
            'akta_kelahiran' => 'Akta Kelahiran',
            'surat_keterangan_lulus' => 'Surat Keterangan Lulus (SKL)',
            'kartu_kesejahteraan' => 'Kartu Kesejahteraan'
        ];

        // 1. Validasi Input
        $validated = $request->validate([
            'jenis_pendaftaran'   => 'required|string',
            'sekolah_asal'        => 'nullable|string|max:255',
            'pernah_paud'         => 'required|in:Ya,Tidak',
            'hobi'                => 'nullable|string|max:255',
            'cita_cita'           => 'nullable|string|max:255',

            'kk'                             => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'ktp_ortu'                       => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'akta_kelahiran'                 => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'surat_keterangan_lulus'         => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'kartu_kesejahteraan'            => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], $customMessages, $customAttributes);

        // 2. Proses upload berkas fisik ke storage
        $fileFields = ['kk', 'ktp_ortu', 'akta_kelahiran', 'surat_keterangan_lulus', 'kartu_kesejahteraan'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('registrasi_berkas', 'public');
                $validated[$field] = $path;
            } else {
                $validated[$field] = null;
            }
        }

        $profilLama = PesertaDidik::where('user_id', $user->id)->first();

        if ($profilLama) {
            // 1. Data untuk tabel Utama (PesertaDidik)
            $dataPeserta = [
                'nama_lengkap'        => $user->name,
            ];

            // 2. Siapkan data relasi dan status baru
            $validated['user_id']           = $user->id;
            $validated['peserta_didik_id']  = $profilLama->id;
            $validated['status_registrasi'] = 'Menunggu Verifikasi';
            $validated['tanggal_daftar']    = now();

            // 3. Cek apakah siswa ini SECARA FISIK sudah pernah membuat data registrasi sebelumnya
            $registrasiEksis = RegistrasiPesertaDidik::where('user_id', $user->id)->first();

            DB::transaction(function () use ($profilLama, $dataPeserta, $validated, $registrasiEksis) {
                // A. Update data kompetensi di tabel utama
                $profilLama->update($dataPeserta);

                if ($registrasiEksis) {
                    // B. JIKA SUDAH ADA: Hapus berkas fisik lama HANYA JIKA siswa mengupload berkas baru
                    $fileFields = ['kk', 'ktp_ortu', 'akta_kelahiran', 'surat_keterangan_lulus', 'kartu_kesejahteraan'];

                    foreach ($fileFields as $field) {
                        // Jika di request form ada file baru, dan di DB lama ada file, hapus file lamanya
                        if (array_key_exists($field, $validated) && $registrasiEksis->$field) {
                            Storage::disk('public')->delete($registrasiEksis->$field);
                        }
                    }

                    // C. Lakukan UPDATE pada data registrasi yang sudah ada (bukan membuat baru)
                    $registrasiEksis->update($validated);
                } else {
                    // D. JIKA BELUM PERNAH ADA: Baru lakukan INSERT data baru
                    RegistrasiPesertaDidik::create($validated);
                }
            });
        } else {
            return redirect()->route('siswa.dashboard')->with('error', 'Profil dasar Anda belum ditemukan. Silakan lengkapi Data Diri Anda terlebih dahulu.');
        }

        return redirect()->route('siswa.dashboard')->with('success', 'Data registrasi Anda berhasil dikirim dan sedang menunggu verifikasi ulang.');
    }
}
