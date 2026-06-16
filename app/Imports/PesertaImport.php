<?php

namespace App\Imports;

use App\Models\PesertaDidik;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class PesertaImport implements ToModel, WithHeadingRow
{
    /**
    * Memetakan setiap baris Excel ke dalam Model PesertaDidik
    */
    public function model(array $row)
    {
        // Skip jika baris kosong (misal nama_lengkap kosong)
        if (empty($row['nama_lengkap'])) {
            return null;
        }

        return new PesertaDidik([
            // I. INFORMASI PENDAFTARAN
            'nomor_pendaftaran'         => $row['nomor_pendaftaran'] ?? 'REG-' . rand(10000, 99999),

            // II. DATA PRIBADI SISWA
            'nama_lengkap'              => $row['nama_lengkap'],
            'jenis_kelamin'             => $row['jenis_kelamin'],
            'nisn'                      => $row['nisn'],
            'nik'                       => $row['nik'],
            'no_kk'                     => $row['no_kk'],
            'tempat_lahir'              => $row['tempat_lahir'],
            // Mengubah format tanggal Excel/Teks menjadi format Y-m-d untuk database
            'tanggal_lahir'             => $this->transformDate($row['tanggal_lahir']),
            'no_registrasi_akta'        => $row['no_registrasi_akta'],
            'agama'                     => $row['agama'],
            'kewarganegaraan'           => $row['kewarganegaraan'] ?? 'WNI',
            'negara_asal'               => $row['negara_asal'],
            'berkebutuhan_khusus'       => $row['berkebutuhan_khusus'],

            // III. ALAMAT TEMPAT TINGGAL
            'alamat'                    => $row['alamat_jalan'] ?? $row['alamat'],
            'rt'                        => $row['rt'],
            'rw'                        => $row['rw'],
            'dusun'                     => $row['dusun'],
            'desa_kelurahan'            => $row['desakelurahan'] ?? $row['desa_kelurahan'],
            'kecamatan'                 => $row['kecamatan'],
            'kode_pos'                  => $row['kode_pos'],
            'lintang'                   => $row['lintang'],
            'bujur'                     => $row['bujur'],
            'tempat_tinggal'            => $row['tempat_tinggal'],
            'moda_transportasi'         => $row['moda_transportasi'],

            // IV. DATA PERIODIK & PROFIL SISWA
            'anak_ke'                   => $row['anak_ke'],
            'pekerjaan_siswa'           => $row['pekerjaan_siswa'],
            'punya_kip'                 => (strtolower($row['punya_kip']) == 'ya' || $row['punya_kip'] == 1) ? true : false,
            'penerima_kip'              => (strtolower($row['penerima_kip']) == 'ya' || $row['penerima_kip'] == 1) ? true : false,
            'tinggi_badan'              => $row['tinggi_badan_cm'] ?? $row['tinggi_badan'],
            'berat_badan'               => $row['berat_badan_kg'] ?? $row['berat_badan'],
            'jarak_sekolah'             => $row['jarak_sekolah'],
            'jarak_kilometer'           => $row['jarak_detail_km'] ?? $row['jarak_kilometer'],
            'waktu_tempuh'              => $row['waktu_tempuh_menit'] ?? $row['waktu_tempuh'],
            'jumlah_saudara'            => $row['jumlah_saudara'],

            // V. DATA ORANG TUA (AYAH)
            'nama_ayah'                 => $row['nama_ayah'],
            'nik_ayah'                  => $row['nik_ayah'],
            'tahun_lahir_ayah'          => $row['tahun_lahir_ayah'],
            'pendidikan_ayah'           => $row['pendidikan_ayah'],
            'pekerjaan_ayah'            => $row['pekerjaan_ayah'],
            'penghasilan_ayah'          => $row['penghasilan_ayah'],
            'kebutuhan_khusus_ayah'     => $row['kebutuhan_khusus_ayah'],

            // VI. DATA ORANG TUA (IBU)
            'nama_ibu'                  => $row['nama_ibu'],
            'nik_ibu'                   => $row['nik_ibu'],
            'tahun_lahir_ibu'           => $row['tahun_lahir_ibu'],
            'pendidikan_ibu'            => $row['pendidikan_ibu'],
            'pekerjaan_ibu'             => $row['pekerjaan_ibu'],
            'penghasilan_ibu'           => $row['penghasilan_ibu'],
            'kebutuhan_khusus_ibu'      => $row['kebutuhan_khusus_ibu'],

            // VII. DATA WALI
            'nama_wali'                 => $row['nama_wali'],
            'nik_wali'                  => $row['nik_wali'],
            'tahun_lahir_wali'          => $row['tahun_lahir_wali'],
            'pendidikan_wali'           => $row['pendidikan_wali'],
            'pekerjaan_wali'            => $row['pekerjaan_wali'],
            'penghasilan_wali'          => $row['penghasilan_wali'],

            // VIII. KONTAK
            'no_hp_ortu'                => $row['no_hp_orang_tua'] ?? $row['no_hp_ortu'],
            'no_hp'                     => $row['no_hp_siswa'] ?? $row['no_hp'],
            'email'                     => $row['email'],

            // IX. BEASISWA & KESEJAHTERAAN
            'jenis_beasiswa'            => $row['jenis_beasiswa'],
            'keterangan_beasiswa'       => $row['keterangan_beasiswa'],
            'tahun_mulai_beasiswa'      => $row['tahun_mulai_beasiswa'],
            'tahun_selesai_beasiswa'    => $row['tahun_selesai_beasiswa'],
            'jenis_kesejahteraan'       => $row['jenis_kesejahteraan'],
            'nomor_kartu_kesejahteraan' => $row['nomor_kartu_kesejahteraan'],
            'nama_pemegang_kartu'       => $row['nama_pemegang_kartu'],
            
            // Mencatat siapa admin yang meng-import (opsional)
            'created_by'                => auth()->id(),
        ]);
    }

    /**
     * Helper untuk mengubah format tanggal bawaan Excel/String ke format Y-m-d database
     */
    private function transformDate($value)
    {
        if (empty($value)) {
            return null;
        }

        try {
            // Jika tanggal dibaca sebagai serial angka Excel (misal: 44378)
            if (is_numeric($value)) {
                return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value))->format('Y-m-d');
            }
            
            // Jika tanggal berupa teks biasa (misal: "2008-12-30" atau "30-12-2008")
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}