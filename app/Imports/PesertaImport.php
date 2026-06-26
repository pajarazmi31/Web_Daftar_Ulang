<?php

namespace App\Imports;

use App\Models\PesertaDidik;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // Tambahkan ini
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PesertaImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        // 1. Abaikan atau lewati jika NISN kosong pada baris Excel
        if (empty(trim($row['nisn']))) {
            return null;
        }

        // Jalankan pembersihan teks pilihan (Agama & Jenis Kelamin)
        $agamaClean = !empty($row['agama']) ? ucwords(strtolower(trim($row['agama']))) : null;
        $jkClean = !empty($row['jenis_kelamin']) ? ucwords(strtolower(trim($row['jenis_kelamin']))) : null;

        // Fallback Email
       $emailSiswa = !empty($row['nisn']) ? trim($row['nisn']) : $row['email'];

        // 2. Cek apakah User dengan NISN / Email tersebut sudah ada
        $user = User::where('email', $emailSiswa)->first();

        if (!$user) {
            // Ambil role_id untuk siswa seperti di PesertaDidikController
            $roleSiswa = DB::table('role')->where('nama_role', 'siswa')->first();
            $roleId = $roleSiswa ? $roleSiswa->id : null;

            // Jika akun belum ada, buat akun baru
            $user = User::create([
                'name'     => $row['nama_lengkap'],
                'email'    => $emailSiswa,
                'password' => Hash::make('smkn1kawali'),
                'role_id'  => $roleId, // Disamakan menggunakan role_id, bukan 'role'
            ]);
        }

        // 3. Cek apakah data Peserta Didik dengan NISN ini sudah ada di tabel peserta_didik
        $pesertaExists = PesertaDidik::where('nisn', $row['nisn'])->exists();
        if ($pesertaExists) {
            return null; // Skip jika siswa sudah terdaftar
        }

        // Amankan konversi angka eksponensial untuk NIK dan No KK
        $nik = is_numeric($row['nik']) ? sprintf("%.0f", $row['nik']) : $row['nik'];
        $no_kk = is_numeric($row['no_kk']) ? sprintf("%.0f", $row['no_kk']) : $row['no_kk'];

        return new PesertaDidik([
            'user_id'            => $user->id,

            // II. DATA PRIBADI SISWA
            'nama_lengkap'              => $row['nama_lengkap'],
            'jenis_kelamin'             => $jkClean,
            'nisn'                      => $row['nisn'],
            'nik'                       => $nik,
            'no_kk'                     => $no_kk,
            'tempat_lahir'              => $row['tempat_lahir'],
            'tanggal_lahir'             => $this->transformDate($row['tanggal_lahir']),
            'no_registrasi_akta'        => $row['no_registrasi_akta'] ?? null,
            'kompetensi_keahlian'       => $row['kompetensi_keahlian'] ?? null,
            'jalur_pendaftaran'         => $row['jalur_pendaftaran'] ?? null,
            'agama'                     => $agamaClean,
            'kewarganegaraan'           => $row['kewarganegaraan'] ?? 'WNI',
            'negara_asal'               => $row['negara_asal'] ?? null,
            'berkebutuhan_khusus'       => !empty($row['berkebutuhan_khusus']) ? json_decode($row['berkebutuhan_khusus'], true) : [],

            // III. ALAMAT TEMPAT TINGGAL
            'alamat'                    => $row['alamat_jalan'] ?? $row['alamat'] ?? null,
            'rt'                        => $row['rt'] ?? null,
            'rw'                        => $row['rw'] ?? null,
            'dusun'                     => $row['dusun'] ?? null,
            'desa_kelurahan'            => $row['desa_kelurahan'] ?? $row['desakelurahan'] ?? null,
            'kecamatan'                 => $row['kecamatan'],
            'kabupaten'                 => $row['kabupaten'],
            'provinsi'                  => $row['provinsi'],
            'kode_pos'                  => $row['kode_pos'] ?? null,
            'lintang'                   => $row['lintang'] ?? null,
            'bujur'                     => $row['bujur'] ?? null,
            'tempat_tinggal'            => $row['tempat_tinggal'] ?? null,
            'moda_transportasi'         => $row['moda_transportasi'] ?? null,

            // IV. DATA PERIODIK & PROFIL SISWA
            'anak_ke'                   => $row['anak_ke'] ?? null,
            'pekerjaan_siswa'           => $row['pekerjaan_siswa'] ?? null,
            'punya_kip'                 => (strtolower($row['punya_kip'] ?? '') == 'ya' || ($row['punya_kip'] ?? '') == 1) ? true : false,
            'penerima_kip'              => (strtolower($row['penerima_kip'] ?? '') == 'ya' || ($row['penerima_kip'] ?? '') == 1) ? true : false,
            'tinggi_badan'              => $row['tinggi_badan_cm'] ?? $row['tinggi_badan'] ?? null,
            'berat_badan'               => $row['berat_badan_kg'] ?? $row['berat_badan'] ?? null,
            'jarak_sekolah'             => $row['jarak_sekolah'] ?? null,
            'jarak_kilometer'           => $row['jarak_detail_km'] ?? $row['jarak_kilometer'] ?? null,
            'waktu_tempuh'              => $row['waktu_tempuh_menit'] ?? $row['waktu_tempuh'] ?? null,
            'jumlah_saudara'            => $row['jumlah_saudara'] ?? null,

            // V. DATA ORANG TUA (AYAH)
            'nama_ayah'                 => $row['nama_ayah'] ?? null,
            'nik_ayah'                  => $row['nik_ayah'] ?? null,
            'tahun_lahir_ayah'          => $row['tahun_lahir_ayah'] ?? null,
            'pendidikan_ayah'           => $row['pendidikan_ayah'] ?? null,
            'pekerjaan_ayah'            => $row['pekerjaan_ayah'] ?? null,
            'penghasilan_ayah'          => $row['penghasilan_ayah'] ?? null,
            'kebutuhan_khusus_ayah'     => !empty($row['kebutuhan_khusus_ayah']) ? json_decode($row['kebutuhan_khusus_ayah'], true) : [],

            // VI. DATA ORANG TUA (IBU)
            'nama_ibu'                  => $row['nama_ibu'],
            'nik_ibu'                   => $row['nik_ibu'] ?? null,
            'tahun_lahir_ibu'           => $row['tahun_lahir_ibu'] ?? null,
            'pendidikan_ibu'            => $row['pendidikan_ibu'] ?? null,
            'pekerjaan_ibu'             => $row['pekerjaan_ibu'] ?? null,
            'penghasilan_ibu'           => $row['penghasilan_ibu'] ?? null,
            'kebutuhan_khusus_ibu'      => !empty($row['kebutuhan_khusus_ibu']) ? json_decode($row['kebutuhan_khusus_ibu'], true) : [],

            // VII. DATA WALI
            'nama_wali'                 => $row['nama_wali'] ?? null,
            'nik_wali'                  => $row['nik_wali'] ?? null,
            'tahun_lahir_wali'          => $row['tahun_lahir_wali'] ?? null,
            'pendidikan_wali'           => $row['pendidikan_wali'] ?? null,
            'pekerjaan_wali'            => $row['pekerjaan_wali'] ?? null,
            'penghasilan_wali'          => $row['penghasilan_wali'] ?? null,

            // VIII. KONTAK
            'no_hp_ortu'                => $row['no_hp_orang_tua'] ?? $row['no_hp_ortu'] ?? null,
            'no_hp'                     => $row['no_hp_siswa'] ?? $row['no_hp'] ?? null,
            'email'                     => $row['email'] ?? null,

            // IX. BEASISWA & KESEJAHTERAAN
            'jenis_beasiswa'            => $row['jenis_beasiswa'] ?? null,
            'keterangan_beasiswa'       => $row['keterangan_beasiswa'] ?? null,
            'tahun_mulai_beasiswa'      => $row['tahun_mulai_beasiswa'] ?? null,
            'tahun_selesai_beasiswa'    => $row['tahun_selesai_beasiswa'] ?? null,
            'jenis_kesejahteraan'       => $row['jenis_kesejahteraan'] ?? null,
            'nomor_kartu_kesejahteraan' => $row['nomor_kartu_kesejahteraan'] ?? null,
            'nama_pemegang_kartu'       => $row['nama_pemegang_kartu'] ?? null,

            'created_by'                => auth()->id(),
        ]);
    }

    public function rules(): array
    {
        return [
            'nama_lengkap'   => 'required|string|max:255',
            'nisn'           => 'required'
        ];
    }

    public function customValidationAttributes()
    {
        return [
            'nama_lengkap'   => 'Nama Lengkap',
            'nisn'           => 'NISN'
        ];
    }

    private function transformDate($value)
    {
        if (empty($value)) {
            return null;
        }

        try {
            if (is_numeric($value)) {
                return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value))->format('Y-m-d');
            }

            $cleanDate = explode(' ', trim($value))[0];
            return Carbon::parse($cleanDate)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
