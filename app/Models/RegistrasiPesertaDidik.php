<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrasiPesertaDidik extends Model
{
    use HasFactory;

    protected $table = 'registrasi_peserta_didik';

    protected $fillable = [
        'peserta_didik_id',
        'kompetensi_keahlian',
        'jenis_pendaftaran',
        'sekolah_asal',
        'pernah_paud',
        'hobi',
        'cita_cita',
        'status_registrasi',
        'kk',
        'ktp_ortu',
        'akta_kelahiran',
        'surat_keterangan_lulus',
        'kartu_kesejahteraan',
        'sptjm',
        'surat_pernyataan_tata_tertib',
    ];

    /**
     * Hubungan Relasi ke data utama Peserta Didik
     */
    public function pesertaDidik()
    {
        return $this->belongsTo(PesertaDidik::class, 'peserta_didik_id');
    }
}