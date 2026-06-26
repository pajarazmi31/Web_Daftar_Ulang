<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\PesertaDidik;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Exports\PesertaExport;
use App\Imports\PesertaImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PesertaTemplateExport;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Validators\ValidationException;

class PesertaDidikController extends Controller
{
    public function index(Request $request)
    {
        // Tangkap input keyword pencarian
        $search = $request->input('search');

        // Menggunakan latest() untuk menampilkan data pendaftar terbaru di atas
        $peserta = PesertaDidik::with('creator')
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nisn', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('admin.data_peserta.index', compact('peserta'));
    }

    public function exportExcel()
    {
        return Excel::download(new PesertaExport, 'data-peserta-didik.xlsx');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            // Menggunakan DB Transaction untuk keamanan pembuatan massal User & PesertaDidik
            DB::transaction(function () use ($request) {
                Excel::import(new PesertaImport, $request->file('file'));
            });

            return redirect()->route('data-peserta.index')
                ->with('success', 'Data peserta didik dan akun siswa berhasil diimport.');
        } catch (ValidationException $e) {
            // Jika terjadi kesalahan validasi pada isi file Excel
            $failures = $e->failures();
            $errorMessages = [];

            foreach ($failures as $failure) {
                // $failure->row() = Baris ke berapa di Excel yang error
                // $failure->attribute() = Nama kolom/field yang error
                // $failure->errors() = Array pesan kesalahannya
                $row = $failure->row();
                $errors = implode(', ', $failure->errors());

                $errorMessages[] = "Baris {$row}: {$errors}";
            }

            // Kembalikan ke halaman sebelumnya dengan membawa daftar error dalam bentuk array
            return redirect()->back()
                ->with('import_errors', $errorMessages)
                ->with('error', 'Import gagal karena terdapat data yang tidak valid pada file Excel.');
        } catch (\Exception $e) {
            // Jika terjadi kesalahan sistem lainnya (misal: database down, file rusak, dll)
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem saat import data: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new PesertaTemplateExport, 'template-import-peserta-didik.xlsx');
    }

    public function create()
    {
        return view('admin.data_peserta.create');
    }

    public function store(Request $request)
    {
        // 1. VALIDASI DATA KETAT (Mencakup semua field dari Model PesertaDidik)
        $validated = $request->validate([
            // TAB 1: Data Pribadi Siswa
            'nama_lengkap'          => 'required|string|max:255',
            'jenis_kelamin'         => 'required|in:Laki-laki,Perempuan',
            'nisn'                  => 'required|string|max:10',
            'nik'                   => 'required|string|max:16',
            'no_kk'                 => 'required|string|max:16',
            'tempat_lahir'          => 'required|string|max:255',
            'tanggal_lahir'         => 'required|date',
            'no_registrasi_akta'    => 'nullable|string|max:255',
            'jalur_pendaftaran'     => 'required|string|max:255',
            'kompetensi_keahlian'   => 'required|string|max:255',
            'agama'                 => 'required|in:Islam,Kristen Protestan,Katolik,Hindu,Buddha,Khonghucu,Kepercayaan Kepada Tuhan YME',
            'kewarganegaraan'       => 'nullable|in:WNI,WNA',
            'negara_asal'           => 'nullable|required_if:kewarganegaraan,WNA|string|max:255',
            'berkebutuhan_khusus'   => 'nullable|array',
            'alamat'                => 'nullable|string',
            'rt'                    => 'nullable|string|max:5',
            'rw'                    => 'nullable|string|max:5',
            'dusun'                 => 'nullable|string|max:255',
            'desa_kelurahan'        => 'nullable|string|max:255',
            'kecamatan'             => 'nullable|string|max:255',
            'kabupaten'             => 'nullable|string|max:255',
            'provinsi'             => 'nullable|string|max:255',
            'kode_pos'              => 'nullable|string|max:10',
            'lintang'               => 'nullable|string|max:50',
            'bujur'                 => 'nullable|string|max:50',
            'tempat_tinggal'        => 'nullable|string|max:255',
            'moda_transportasi'     => 'nullable|string|max:255',
            'anak_ke'               => 'nullable|integer|min:1',
            'pekerjaan_siswa'       => 'nullable|string|max:255',
            'punya_kip'             => 'nullable|boolean',
            'penerima_kip'          => 'nullable|boolean',

            // TAB 2: Data Ayah Kandung
            'nama_ayah'             => 'nullable|string|max:255',
            'nik_ayah'              => 'nullable|string|max:16',
            'tahun_lahir_ayah'      => 'nullable|numeric|between:1900,2030',
            'pendidikan_ayah'       => 'nullable|string|max:255',
            'pekerjaan_ayah'        => 'nullable|string|max:255',
            'penghasilan_ayah'      => 'nullable|string|max:255',
            'kebutuhan_khusus_ayah' => 'nullable|array', // Disesuaikan ke array

            // TAB 3: Data Ibu Kandung
            'nama_ibu'              => 'nullable|string|max:255',
            'nik_ibu'               => 'nullable|string|max:16',
            'tahun_lahir_ibu'       => 'nullable|numeric|between:1900,2030',
            'pendidikan_ibu'        => 'nullable|string|max:255',
            'pekerjaan_ibu'         => 'nullable|string|max:255',
            'penghasilan_ibu'       => 'nullable|string|max:255',
            'kebutuhan_khusus_ibu'  => 'nullable|array', // Disesuaikan ke array

            // TAB 4: Data Wali
            'nama_wali'             => 'nullable|string|max:255',
            'nik_wali'              => 'nullable|string|max:16',
            'tahun_lahir_wali'      => 'nullable|numeric|between:1900,2030',
            'pendidikan_wali'       => 'nullable|string|max:255',
            'pekerjaan_wali'        => 'nullable|string|max:255',
            'penghasilan_wali'      => 'nullable|string|max:255',

            // TAB 5: Kontak & Periodik
            'no_hp_ortu'            => 'nullable|string|max:20',
            'no_hp'                 => 'nullable|string|max:20',
            'email'                 => 'nullable|email|max:255',
            'tinggi_badan'          => 'nullable|numeric|min:30|max:250', // Menggunakan numeric karena cast model 'float'
            'berat_badan'           => 'nullable|numeric|min:5|max:200',  // Menggunakan numeric karena cast model 'float'
            'jarak_sekolah'         => 'nullable|string|max:255',
            'jarak_kilometer'       => 'nullable|numeric',
            'waktu_tempuh'          => 'nullable|integer|min:0',
            'jumlah_saudara'        => 'nullable|integer|min:0',

            // DATA TAMBAHAN: Beasiswa (Ada di Model $fillable)
            'jenis_beasiswa'         => 'nullable|string|max:255',
            'keterangan_beasiswa'    => 'nullable|string',
            'tahun_mulai_beasiswa'   => 'nullable|numeric|between:2000,2050',
            'tahun_selesai_beasiswa' => 'nullable|numeric|between:2000,2050',

            // DATA TAMBAHAN: Kesejahteraan (Ada di Model $fillable)
            'jenis_kesejahteraan'       => 'nullable|string|max:255',
            'nomor_kartu_kesejahteraan' => 'nullable|string|max:50',
            'nama_pemegang_kartu'       => 'nullable|string|max:255',
        ], [
            // Kustomisasi pesan error ke Bahasa Indonesia
            'required' => 'Kolom ini wajib diisi.',
            'digits'   => 'Harus berupa :digits digit angka.',
            'date'     => 'Format tanggal tidak valid.',
        ]);

        // 2. MODIFIKASI DATA KHUSUS
        $validated['created_by'] = auth()->id();

        $validated['punya_kip'] = $request->has('punya_kip');
        $validated['penerima_kip'] = $request->has('penerima_kip');
        $validated['berkebutuhan_khusus'] = $request->has('berkebutuhan_khusus') ? $request->input('berkebutuhan_khusus') : [];
        $validated['kebutuhan_khusus_ayah'] = $request->has('kebutuhan_khusus_ayah') ? $request->input('kebutuhan_khusus_ayah') : [];
        $validated['kebutuhan_khusus_ibu'] = $request->has('kebutuhan_khusus_ibu') ? $request->input('kebutuhan_khusus_ibu') : [];

        // ==================== LOGIKA AUTO CREATE AKUN SISWA ====================
        $userId = null;
        if (!empty($request->nisn)) {
            $roleSiswa = DB::table('role')->where('nama_role', 'siswa')->first();
            $roleId = $roleSiswa ? $roleSiswa->id : null;

            $existingUser = User::where('email', $request->nisn)->first();

            if (!$existingUser) {
                $userSiswa = User::create([
                    'name'     => $request->nama_lengkap,
                    'email'    => $request->nisn,
                    'password' => Hash::make('smkn1kawali'),
                    'role_id'  => $roleId,
                ]);
                $userId = $userSiswa->id;
            } else {
                $userId = $existingUser->id;
            }
        }

        // Isikan user_id ke array $validated sebelum eksekusi create database
        $validated['user_id'] = $userId;

        // Eksekusi penyimpanan massal
        PesertaDidik::create($validated);

        return redirect()->route('data-peserta.index')->with('success', 'Data pendaftar berhasil disimpan.');
    }

    public function show($id)
    {
        // Mengambil data peserta didik beserta user pembuatnya
        $peserta = PesertaDidik::with('creator')->findOrFail($id);

        return view('admin.data_peserta.detail', compact('peserta'));
    }

    public function edit($id)
    {
        $peserta = PesertaDidik::findOrFail($id);
        return view('admin.data_peserta.edit', compact('peserta'));
    }

    public function update(Request $request, $id)
    {
        $peserta = PesertaDidik::findOrFail($id);

        // Lakukan validasi yang sama persis seperti pada method store() demi keamanan data mutasi
        $validated = $request->validate([
            // TAB 1
            'nama_lengkap'          => 'required|string|max:255',
            'jenis_kelamin'         => 'required|in:Laki-laki,Perempuan',
            'nisn'                  => 'required|string|max:10',
            'nik'                   => 'required|string|max:16',
            'no_kk'                 => 'required|string|max:16',
            'tempat_lahir'          => 'required|string|max:255',
            'tanggal_lahir'         => 'required|date',
            'no_registrasi_akta'    => 'nullable|string|max:255',
            'jalur_pendaftaran'     => 'required|string|max:255',
            'kompetensi_keahlian'   => 'required|string|max:255',
            'agama'                 => 'required|in:Islam,Kristen Protestan,Katolik,Hindu,Buddha,Khonghucu,Kepercayaan Kepada Tuhan YME',
            'kewarganegaraan'       => 'nullable|in:WNI,WNA',
            'negara_asal'           => 'nullable|required_if:kewarganegaraan,WNA|string|max:255',
            'berkebutuhan_khusus'   => 'nullable|array',
            'alamat'                => 'nullable|string',
            'rt'                    => 'nullable|string|max:5',
            'rw'                    => 'nullable|string|max:5',
            'dusun'                 => 'nullable|string|max:255',
            'desa_kelurahan'        => 'nullable|string|max:255',
            'kecamatan'             => 'nullable|string|max:255',
            'kabupaten'             => 'nullable|string|max:255',
            'provinsi'             => 'nullable|string|max:255',
            'kode_pos'              => 'nullable|string|max:10',
            'lintang'               => 'nullable|string|max:50',
            'bujur'                 => 'nullable|string|max:50',
            'tempat_tinggal'        => 'nullable|string|max:255',
            'moda_transportasi'     => 'nullable|string|max:255',
            'anak_ke'               => 'nullable|integer|min:1',
            'pekerjaan_siswa'       => 'nullable|string|max:255',
            'punya_kip'             => 'nullable|boolean',
            'penerima_kip'          => 'nullable|boolean',

            // TAB 2
            'nama_ayah'             => 'nullable|string|max:255',
            'nik_ayah'              => 'nullable|string|max:16',
            'tahun_lahir_ayah' => 'nullable|numeric|between:1900,2030',
            'pendidikan_ayah'       => 'nullable|string|max:255',
            'pekerjaan_ayah'        => 'nullable|string|max:255',
            'penghasilan_ayah'      => 'nullable|string|max:255',
            'kebutuhan_khusus_ayah' => 'nullable|array', // Disesuaikan ke array

            // TAB 3
            'nama_ibu'              => 'nullable|string|max:255',
            'nik_ibu'               => 'nullable|string|max:16',
            'tahun_lahir_ibu'  => 'nullable|numeric|between:1900,2030',
            'pendidikan_ibu'        => 'nullable|string|max:255',
            'pekerjaan_ibu'         => 'nullable|string|max:255',
            'penghasilan_ibu'       => 'nullable|string|max:255',
            'kebutuhan_khusus_ibu'  => 'nullable|array', // Disesuaikan ke array

            // TAB 4
            'nama_wali'             => 'nullable|string|max:255',
            'nik_wali'              => 'nullable|string|max:16',
            'tahun_lahir_wali' => 'nullable|numeric|between:1900,2030',
            'pendidikan_wali'       => 'nullable|string|max:255',
            'pekerjaan_wali'        => 'nullable|string|max:255',
            'penghasilan_wali'      => 'nullable|string|max:255',

            // TAB 5
            'no_hp_ortu'            => 'nullable|string|max:20',
            'no_hp'                 => 'nullable|string|max:20',
            'email'                 => 'nullable|email|max:255',
            'tinggi_badan'          => 'nullable|numeric|min:30|max:250',
            'berat_badan'           => 'nullable|numeric|min:5|max:200',
            'jarak_sekolah'         => 'nullable|string|max:255',
            'jarak_kilometer'       => 'nullable|numeric', // Sebelumnya hilang di update
            'waktu_tempuh'          => 'nullable|integer|min:0',  // Sebelumnya hilang di update
            'jumlah_saudara'        => 'nullable|integer|min:0',

            // DATA TAMBAHAN: Beasiswa
            'jenis_beasiswa'         => 'nullable|string|max:255',
            'keterangan_beasiswa'    => 'nullable|string',
            'tahun_mulai_beasiswa'   => 'nullable|numeric|between:2000,2050',
            'tahun_selesai_beasiswa' => 'nullable|numeric|between:2000,2050',

            // DATA TAMBAHAN: Kesejahteraan
            'jenis_kesejahteraan'       => 'nullable|string|max:255',
            'nomor_kartu_kesejahteraan' => 'nullable|string|max:50',
            'nama_pemegang_kartu'       => 'nullable|string|max:255',
        ]);

        // Manipulasi checkbox boolean saat update
        $validated['punya_kip'] = $request->has('punya_kip');
        $validated['penerima_kip'] = $request->has('penerima_kip');

        // Antisipasi jika user mengosongkan checkbox (array) saat proses edit data
        $validated['berkebutuhan_khusus'] = $request->has('berkebutuhan_khusus') ? $request->input('berkebutuhan_khusus') : [];
        $validated['kebutuhan_khusus_ayah'] = $request->has('kebutuhan_khusus_ayah') ? $request->input('kebutuhan_khusus_ayah') : [];
        $validated['kebutuhan_khusus_ibu'] = $request->has('kebutuhan_khusus_ibu') ? $request->input('kebutuhan_khusus_ibu') : [];

        if ($peserta->update($validated)) {
            // UBAH BARIS INI: Jangan gunakan redirect()->back()
            return redirect()->route('data-peserta.index')->with('success', 'Rekam data biodata siswa berhasil diperbarui.');
        }

        // Ini sebagai cadangan jika gagal
        return redirect()->route('data-peserta.index')->with('error', 'Gagal memperbarui data.');
    }

    public function destroy($id)
    {
        $peserta = PesertaDidik::findOrFail($id);
        $peserta->delete();

        return redirect()->route('data-peserta.index')->with('success', 'Data peserta didik berhasil dihapus secara permanen dari sistem.');
    }
}
