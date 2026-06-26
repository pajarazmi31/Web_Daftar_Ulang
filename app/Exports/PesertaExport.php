<?php

namespace App\Exports;

use App\Models\PesertaDidik; 
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PesertaExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * Mengambil seluruh data dari database
    */
    public function collection()
    {
        return PesertaDidik::all();
    }

    /**
    * Mengatur judul kolom di baris pertama Excel (Sesuai Struktur Migration)
    */
    public function headings(): array
    {
        return [
            
            // II. DATA PRIBADI SISWA
            'Nama Lengkap',
            'Jenis Kelamin',
            'NISN',
            'NIK',
            'No. KK',
            'Tempat Lahir',
            'Tanggal Lahir',
            'No. Registrasi Akta',
            'Kompetensi Keahlian',
            'Jalur Pendaftaran',
            'Agama',
            'Kewarganegaraan',
            'Negara Asal',
            'Berkebutuhan Khusus',
            
            // III. ALAMAT TEMPAT TINGGAL
            'Alamat Jalan',
            'RT',
            'RW',
            'Dusun',
            'Desa/Kelurahan',
            'Kecamatan',
            'Kabupaten',
            'Provinsi',
            'Kode Pos',
            'Lintang',
            'Bujur',
            'Tempat Tinggal',
            'Moda Transportasi',
            
            // IV. DATA PERIODIK & PROFIL SISWA
            'Anak Ke',
            'Pekerjaan Siswa',
            'Punya KIP',
            'Penerima KIP',
            'Tinggi Badan (cm)',
            'Berat Badan (kg)',
            'Jarak Sekolah',
            'Jarak Detail (km)',
            'Waktu Tempuh (menit)',
            'Jumlah Saudara',
            
            // V. DATA ORANG TUA (AYAH)
            'Nama Ayah',
            'NIK Ayah',
            'Tahun Lahir Ayah',
            'Pendidikan Ayah',
            'Pekerjaan Ayah',
            'Penghasilan Ayah',
            'Kebutuhan Khusus Ayah',
            
            // VI. DATA ORANG TUA (IBU)
            'Nama Ibu',
            'NIK Ibu',
            'Tahun Lahir Ibu',
            'Pendidikan Ibu',
            'Pekerjaan Ibu',
            'Penghasilan Ibu',
            'Kebutuhan Khusus Ibu',
            
            // VII. DATA WALI (JIKA ADA)
            'Nama Wali',
            'NIK Wali',
            'Tahun Lahir Wali',
            'Pendidikan Wali',
            'Pekerjaan Wali',
            'Penghasilan Wali',
            
            // VIII. KONTAK
            'No. HP Orang Tua',
            'No. HP Siswa',
            'Email',
            
            // IX. BEASISWA & KESEJAHTERAAN
            'Jenis Beasiswa',
            'Keterangan Beasiswa',
            'Tahun Mulai Beasiswa',
            'Tahun Selesai Beasiswa',
            'Jenis Kesejahteraan',
            'Nomor Kartu Kesejahteraan',
            'Nama Pemegang Kartu'
        ];
    }

    /**
    * Memetakan data dari database ke setiap kolom Excel secara berurutan
    */
    public function map($peserta): array
    {
        return [

            // II. DATA PRIBADI SISWA
            $peserta->nama_lengkap,
            $peserta->jenis_kelamin,
            $peserta->nisn,
            $peserta->nik,
            $peserta->no_kk,
            $peserta->tempat_lahir,
            $peserta->tanggal_lahir,
            $peserta->no_registrasi_akta,
            $peserta->kompetensi_keahlian,
            $peserta->jalur_pendaftaran,
            $peserta->agama,
            $peserta->kewarganegaraan,
            $peserta->negara_asal,
            $peserta->berkebutuhan_khusus,

            // III. ALAMAT TEMPAT TINGGAL
            $peserta->alamat,
            $peserta->rt,
            $peserta->rw,
            $peserta->dusun,
            $peserta->desa_kelurahan,
            $peserta->kecamatan,
            $peserta->kabupaten,
            $peserta->provinsi,
            $peserta->kode_pos,
            $peserta->lintang,
            $peserta->bujur,
            $peserta->tempat_tinggal,
            $peserta->moda_transportasi,

            // IV. DATA PERIODIK & PROFIL SISWA
            $peserta->anak_ke,
            $peserta->pekerjaan_siswa,
            $peserta->punya_kip ? 'Ya' : 'Tidak', // Mengubah boolean menjadi teks agar informatif di Excel
            $peserta->penerima_kip ? 'Ya' : 'Tidak',
            $peserta->tinggi_badan,
            $peserta->berat_badan,
            $peserta->jarak_sekolah,
            $peserta->jarak_kilometer,
            $peserta->waktu_tempuh,
            $peserta->jumlah_saudara,

            // V. DATA ORANG TUA (AYAH)
            $peserta->nama_ayah,
            $peserta->nik_ayah,
            $peserta->tahun_lahir_ayah,
            $peserta->pendidikan_ayah,
            $peserta->pekerjaan_ayah,
            $peserta->penghasilan_ayah,
            $peserta->kebutuhan_khusus_ayah,

            // VI. DATA ORANG TUA (IBU)
            $peserta->nama_ibu,
            $peserta->nik_ibu,
            $peserta->tahun_lahir_ibu,
            $peserta->pendidikan_ibu,
            $peserta->pekerjaan_ibu,
            $peserta->penghasilan_ibu,
            $peserta->kebutuhan_khusus_ibu,

            // VII. DATA WALI
            $peserta->nama_wali,
            $peserta->nik_wali,
            $peserta->tahun_lahir_wali,
            $peserta->pendidikan_wali,
            $peserta->pekerjaan_wali,
            $peserta->penghasilan_wali,

            // VIII. KONTAK
            $peserta->no_hp_ortu,
            $peserta->no_hp,
            $peserta->email,

            // IX. BEASISWA & KESEJAHTERAAN
            $peserta->jenis_beasiswa,
            $peserta->keterangan_beasiswa,
            $peserta->tahun_mulai_beasiswa,
            $peserta->tahun_selesai_beasiswa,
            $peserta->jenis_kesejahteraan,
            $peserta->nomor_kartu_kesejahteraan,
            $peserta->nama_pemegang_kartu,
        ];
    }
}