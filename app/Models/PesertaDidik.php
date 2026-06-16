<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PesertaDidik extends Model
{
    protected $table = 'peserta_didik';

    /**
     * Kolom guarded untuk keamanan mass assignment.
     * Karena menggunakan $fillable secara spesifik, $guarded bisa tetap diisi ['id'].
     */
    protected $guarded = ['id'];

    /**
     * Atribut yang dapat diisi secara massal (Mass Assignable).
     */
    protected $fillable = [
        'created_by',
        'nomor_pendaftaran',
        
        // DATA PRIBADI
        'nama_lengkap',
        'jenis_kelamin',
        'nisn',
        'nik',
        'no_kk',
        'tempat_lahir',
        'tanggal_lahir',
        'no_registrasi_akta',
        'agama',
        'kewarganegaraan',
        'negara_asal',
        'berkebutuhan_khusus',
        'alamat',
        'rt',
        'rw',
        'dusun',
        'desa_kelurahan',
        'kecamatan',
        'kode_pos',
        'lintang',
        'bujur',
        'tempat_tinggal',
        'moda_transportasi',
        'anak_ke',
        'pekerjaan_siswa',
        'punya_kip',
        'penerima_kip',

        // DATA AYAH
        'nama_ayah',
        'nik_ayah',
        'tahun_lahir_ayah',
        'pendidikan_ayah',
        'pekerjaan_ayah',
        'penghasilan_ayah',
        'kebutuhan_khusus_ayah',

        // DATA IBU
        'nama_ibu',
        'nik_ibu',
        'tahun_lahir_ibu',
        'pendidikan_ibu',
        'pekerjaan_ibu',
        'penghasilan_ibu',
        'kebutuhan_khusus_ibu',

        // DATA WALI
        'nama_wali',
        'nik_wali',
        'tahun_lahir_wali',
        'pendidikan_wali',
        'pekerjaan_wali',
        'penghasilan_wali',

        // KONTAK
        'no_hp_ortu',
        'no_hp',
        'email',

        // DATA PERIODIK
        'tinggi_badan',
        'berat_badan',
        'jarak_sekolah',
        'jarak_kilometer',
        'waktu_tempuh',
        'jumlah_saudara',

        // BEASISWA
        'jenis_beasiswa',
        'keterangan_beasiswa',
        'tahun_mulai_beasiswa',
        'tahun_selesai_beasiswa',

        // KESEJAHTERAAN
        'jenis_kesejahteraan',
        'nomor_kartu_kesejahteraan',
        'nama_pemegang_kartu',
    ];

    /**
     * Cast tipe data atribut saat diakses oleh Eloquent.
     */
protected function casts(): array
{
    return [
        'tanggal_lahir' => 'date',
        'punya_kip' => 'boolean',
        'penerima_kip' => 'boolean',
        
        // Tambahkan ini agar array otomatis diubah jadi JSON string
        'berkebutuhan_khusus' => 'array', 
        'kebutuhan_khusus_ayah' => 'array', // tambahkan jika ini juga berupa checkbox
        'kebutuhan_khusus_ibu' => 'array',  // tambahkan jika ini juga berupa checkbox

        'anak_ke' => 'integer',
        'waktu_tempuh' => 'integer',
        'jumlah_saudara' => 'integer',
        'tahun_lahir_ayah' => 'integer',
        'tahun_lahir_ibu' => 'integer',
        'tahun_lahir_wali' => 'integer',
        'tahun_mulai_beasiswa' => 'integer',
        'tahun_selesai_beasiswa' => 'integer',
        'tinggi_badan' => 'float',
        'berat_badan' => 'float',
        'jarak_kilometer' => 'float',
    ];
}

    /*
    |--------------------------------------------------------------------------
    | Relasi Model
    |--------------------------------------------------------------------------
    */

    public function creator()
    {
        // Relasi BelongsTo: Kolom created_by merujuk ke kolom id di tabel users
        return $this->belongsTo(User::class, 'created_by');
    }

    public function registrasi()
    {
        return $this->hasOne(RegistrasiPesertaDidik::class);
    }
}