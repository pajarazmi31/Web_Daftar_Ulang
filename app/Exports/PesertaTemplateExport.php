<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class PesertaTemplateExport implements FromArray, WithHeadings, WithTitle
{
    /**
     * Mengembalikan array kosong karena kita hanya butuh template judul kolomnya saja.
     */
    public function array(): array
    {
        return [];
    }

    /**
     * Menentukan judul sheet di dalam Excel
     */
    public function title(): string
    {
        return 'Template Import Siswa';
    }

    /**
     * Menyusun baris pertama Excel sebagai petunjuk kolom input (Sesuai Kebutuhan Import)
     */
    public function headings(): array
    {
        return [
            // I. INFORMASI PENDAFTARAN
            'Nomor Pendaftaran',
            
            // II. DATA PRIBADI SISWA
            'Nama Lengkap',
            'Jenis Kelamin',
            'NISN',
            'NIK',
            'No KK', // Diubah dari 'No. KK' agar lebih aman
            'Tempat Lahir',
            'Tanggal Lahir',
            'No Registrasi Akta',
            'Agama',
            'Kewarganegaraan',
            'Negara Asal',
            'Berkebutuhan Khusus',
            
            // III. ALAMAT TEMPAT TINGGAL
            'Alamat Jalan',
            'RT',
            'RW',
            'Dusun',
            'Desa Kelurahan',
            'Kecamatan',
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
            'Tinggi Badan CM',     // Diubah dari 'Tinggi Badan (cm)'
            'Berat Badan KG',      // Diubah dari 'Berat Badan (kg)'
            'Jarak Sekolah',
            'Jarak Detail KM',     // Diubah dari 'Jarak Detail (km)'
            'Waktu Tempuh Menit',  // Diubah dari 'Waktu Tempuh (menit)'
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
            
            // VII. DATA WALI
            'Nama Wali',
            'NIK Wali',
            'Tahun Lahir Wali',
            'Pendidikan Wali',
            'Pekerjaan Wali',
            'Penghasilan Wali',
            
            // VIII. KONTAK
            'No HP Orang Tua',
            'No HP Siswa',
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
}