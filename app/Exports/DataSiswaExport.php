<?php

namespace App\Exports;

use App\Models\PesertaDidik;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataSiswaExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $kompetensiKeahlian;

    // Menerima filter kompetensi keahlian dari controller
    public function __construct($kompetensiKeahlian = null)
    {
        $this->kompetensiKeahlian = $kompetensiKeahlian;
    }

    public function query()
    {
        // Join tabel peserta_didik dengan registrasi_peserta_didik
        $query = PesertaDidik::query()
            ->join('registrasi_peserta_didik', 'peserta_didik.id', '=', 'registrasi_peserta_didik.peserta_didik_id')
            ->select('peserta_didik.*', 'registrasi_peserta_didik.kompetensi_keahlian', 'registrasi_peserta_didik.jenis_pendaftaran', 'registrasi_peserta_didik.sekolah_asal', 'registrasi_peserta_didik.status_registrasi');

        // Terapkan filter jika dipilih
        if ($this->kompetensiKeahlian) {
            $query->where('registrasi_peserta_didik.kompetensi_keahlian', $this->kompetensiKeahlian);
        }

        return $query;
    }

    // Menentukan Header Kolom Excel
    public function headings(): array
    {
        return [
            'Nomor Pendaftaran',
            'Nama Lengkap',
            'Jenis Kelamin',
            'NISN',
            'NIK',
            'Kompetensi Keahlian (Jurusan)',
            'Sekolah Asal',
            'Jenis Pendaftaran',
            'Status Registrasi',
            'Agama',
            'Tempat, Tanggal Lahir',
            'Alamat Lengkap',
            'No. HP Siswa',
            'No. HP Ortu',
            'Email',
            'KIP Punya/Penerima',
            'Jenis Beasiswa'
        ];
    }

    // Memetakan data model ke dalam kolom Excel
    public function map($row): array
    {
        return [
            $row->nomor_pendaftaran ?? '-',
            $row->nama_lengkap,
            $row->jenis_kelamin,
            $row->nisn ?? '-',
            "'" . $row->nik, // Menambahkan kutip satu agar NIK dianggap string dan tidak pecah di Excel
            $row->kompetensi_keahlian ?? 'Belum Memilih',
            $row->sekolah_asal ?? '-',
            $row->jenis_pendaftaran,
            $row->status_registrasi,
            $row->agama,
            $row->tempat_lahir . ', ' . \Carbon\Carbon::parse($row->tanggal_lahir)->format('d-m-Y'),
            $row->alamat . " RT: $row->rt / RW: $row->rw, Desa: $row->desa_kelurahan, Kec: $row->kecamatan",
            $row->no_hp ?? '-',
            $row->no_hp_ortu ?? '-',
            $row->email ?? '-',
            ($row->punya_kip ? 'Punya' : 'Tidak') . ' / ' . ($row->penerima_kip ? 'Menerima' : 'Tidak'),
            $row->jenis_beasiswa ?? 'Tidak Ada',
        ];
    }

    // Styling Header agar terlihat profesional
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1E293B'] // Slate 800 (Warna gelap elegan)
                ]
            ],
        ];
    }
}