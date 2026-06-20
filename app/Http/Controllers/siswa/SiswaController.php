<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PesertaDidik;
use App\Models\RegistrasiPesertaDidik;
use Illuminate\Support\Facades\Auth;
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

        // Ambil data peserta milik siswa yang login
        $peserta = PesertaDidik::where('user_id', $user->id)->first();

        // Ambil record registrasi untuk mengecek status approval pendaftaran
        $registrasi = RegistrasiPesertaDidik::where('user_id', $user->id)->first();

        // Siswa dianggap sudah registrasi jika datanya sudah ada di PesertaDidik ATAU di tabel registrasi
        $sudahRegistrasi = ($peserta || $registrasi) ? true : false;
        $statusRegistrasi = $registrasi ? $registrasi->status : ($peserta ? 'disetujui' : 'belum');

        return view('siswa.dashboard', compact('peserta', 'sudahRegistrasi', 'statusRegistrasi'));
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
            'required' => 'Kolom :attribute wajib diisi.',
            'numeric'  => 'Kolom :attribute harus berupa angka.',
            'digits'   => 'Kolom :attribute harus berukuran tepat :digits digit.',
            'unique'   => ':attribute sudah terdaftar di sistem, gunakan nomor lain.',
            'in'       => 'Pilihan pada kolom :attribute tidak valid.',
            'date'     => 'Format tanggal pada :attribute salah.',
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
            'agama'              => 'required|string',
            'kewarganegaraan'    => 'required|in:WNI,WNA',
            'negara_asal'        => 'required_if:kewarganegaraan,WNA|nullable|string|max:255',
            'berkebutuhan_khusus' => 'nullable|array',
            'alamat'             => 'required|string',
            'rt'                 => 'nullable|string|max:5',
            'rw'                 => 'nullable|string|max:5',
            'dusun'              => 'nullable|string|max:255',
            'desa_kelurahan'     => 'required|string|max:255',
            'kecamatan'          => 'required|string|max:255',
            'kode_pos'           => 'nullable|string|max:10',
            'lintang'            => 'nullable|string|max:255',
            'bujur'              => 'nullable|string|max:255',
            'tempat_tinggal'     => 'required|string',
            'moda_transportasi'  => 'required|string',
            'anak_ke'            => 'required|integer|min:1',
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

        return redirect()->route('siswa.data-diri.index')
            ->with('success', 'Data diri berhasil diperbarui!')
            ->withInput(['tab' => $request->tab]);
    }

    /**
     * 3. Halaman registrasi mandiri oleh siswa
     */
    public function registrasi()
    {
        $user = Auth::user();

        // FITUR PROTEKSI: Cek apakah data siswa sudah ada di tabel PesertaDidik (diinput operator/mandiri)
        $cekPeserta = PesertaDidik::where('user_id', $user->id)->exists();

        // Cek juga di tabel registrasi status perantara
        $cekRegistrasi = RegistrasiPesertaDidik::where('user_id', $user->id)->exists();

        // Gabungkan kondisi: Jika salah satu bernilai true, kunci akses registrasi siswa!
        $sudahRegistrasi = ($cekPeserta || $cekRegistrasi);

        // Ambil data dasar user untuk pre-fill data (opsional)
        $peserta = PesertaDidik::where('user_id', $user->id)->first();

        return view('siswa.registrasi', compact('peserta', 'sudahRegistrasi'));
    }

    /**
     * 4. Proses simpan registrasi mandiri beserta upload berkas lampiran
     */
    public function storeRegistrasi(Request $request)
    {
        $user = Auth::user();

        // FITUR KESELAMATAN GANDA: Cek kembali sebelum insert untuk menghindari bypass bypass URL/Postman
        $cekPeserta = PesertaDidik::where('user_id', $user->id)->exists();
        $cekRegistrasi = RegistrasiPesertaDidik::where('user_id', $user->id)->exists();

        if ($cekPeserta || $cekRegistrasi) {
            return redirect()->route('siswa.dashboard')->with('error', 'Registrasi tidak dapat dilakukan. Akun Anda sudah terdaftar atau diinput oleh Operator.');
        }

        // Validasi ketat gabungan input Jurusan, Berkas File, dan Identitas Dasar Peserta Didik
        $validated = $request->validate([
            // Input Pilihan Jurusan & Sekolah
            'kompetensi_keahlian' => 'required|string',
            'jalur_pendaftaran'   => 'required|string',
            'jenis_pendaftaran'   => 'required|string',
            'sekolah_asal'        => 'nullable|string|max:255',
            'pernah_paud'         => 'required|in:Ya,Tidak',
            'hobi'                => 'nullable|string|max:255',
            'cita_cita'           => 'nullable|string|max:255',

            // Berkas-berkas lampiran (Max 2MB per file)
            'kk'                             => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'ktp_ortu'                       => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'akta_kelahiran'                 => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'surat_keterangan_lulus'         => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'kartu_kesejahteraan'            => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'sptjm'                          => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'surat_pernyataan_tata_tertib'   => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // --- PROSES UPLOAD FILE ATTACHMENT ---
        $fileFields = ['kk', 'ktp_ortu', 'akta_kelahiran', 'surat_keterangan_lulus', 'kartu_kesejahteraan', 'sptjm', 'surat_pernyataan_tata_tertib'];
        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                // Menyimpan berkas ke direktori storage/app/public/registrasi_berkas
                $path = $request->file($field)->store('registrasi_berkas', 'public');
                $validated[$field] = $path; // Amankan path ke dalam array array insert
            }
        }

        // Data identitas fallback otomatis dari user login (bisa dikondisikan sesuai kebutuhan database Anda)
        $validated['user_id']           = $user->id;
        $validated['created_by']        = $user->id;
        $validated['nama_lengkap']      = $user->name; // Diambil dari default nama akun register user
        $validated['nomor_pendaftaran'] = 'REG-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        // Jika di tabel database Anda nama kolomnya 'nama' bukan 'nama_lengkap'
        $validated['nama']              = $user->name;

        // 1. Simpan data ke tabel Utama Peserta Didik
        PesertaDidik::create($validated);

        // 2. Simpan record log ke tabel perantara Registrasi untuk tracking approval admin/operator
        RegistrasiPesertaDidik::create([
            'user_id'        => $user->id,
            'status'         => 'pending',
            'tanggal_daftar' => now(),
        ]);

        return redirect()->route('siswa.dashboard')->with('success', 'Registrasi mandiri berhasil diselesaikan! Berkas Anda sedang ditinjau oleh operator.');
    }
}
