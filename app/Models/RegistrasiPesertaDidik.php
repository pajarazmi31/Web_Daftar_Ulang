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
        'user_id',
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
    ];

    /**
     * Hubungan Relasi ke data utama Peserta Didik
     */
    public function pesertaDidik()
    {
        return $this->belongsTo(PesertaDidik::class, 'peserta_didik_id');
    }

    // Di dalam model RegistrasiPesertaDidik
    public function user()
    {
        // Tambahkan parameter kedua jika nama kolomnya 'id_user' bukan 'user_id'
        return $this->belongsTo(User::class, 'user_id');
    }
}
