<?php

namespace App\Exports;

use App\Models\PesertaDidik;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Http\Request;

class DataSiswaExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $jurusan;
    protected $rowNumber = 0;

    // 1. Tangkap lemparan filter jurusan dari Controller
    public function __construct($jurusan = null)
    {
        $this->jurusan = $jurusan;
    }

    // 2. Jalankan Query terfilter berdasarkan Jurusan
    public function query()
    {
        $query = PesertaDidik::query()
            ->join('registrasi_peserta_didik', 'peserta_didik.id', '=', 'registrasi_peserta_didik.peserta_didik_id')
            ->select(
                'peserta_didik.nama_lengkap',
                'peserta_didik.nisn',
                'peserta_didik.nik',
                'registrasi_peserta_didik.kompetensi_keahlian',
                'registrasi_peserta_didik.sekolah_asal',
                'registrasi_peserta_didik.status_registrasi'
            );

        // Jika filter jurusan dipilih, saring datanya
        if ($this->jurusan) {
            $query->where('registrasi_peserta_didik.kompetensi_keahlian', $this->jurusan);
        }

        return $query->latest('peserta_didik.created_at');
    }

    // 3. Tentukan Judul Header Kolom di Excel
    public function headings(): array
    {
        return [
            'No',
            'Nama Lengkap',
            'NISN',
            'NIK',
            'Jurusan / Kompetensi Keahlian',
            'Asal Sekolah',
            'Status Registrasi'
        ];
    }

    // 4. Petakan (Mapping) data agar masuk ke kolom yang tepat
    public function map($row): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $row->nama_lengkap,
            "'" . $row->nisn, // Menambahkan kutip tunggal (') agar angka NISN tidak hancur/berubah format di Excel
            "'" . $row->nik,  // Menambahkan kutip tunggal (') agar angka NIK tidak terpotong (Scientific Notation)
            $row->kompetensi_keahlian ?? '-',
            $row->sekolah_asal ?? '-',
            $row->status_registrasi ?? '-'
        ];
    }
}