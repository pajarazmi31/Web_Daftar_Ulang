<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registrasi_peserta_didik', function (Blueprint $table) {

            $table->id();

            $table->foreignId('peserta_didik_id')
                ->constrained('peserta_didik')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('kompetensi_keahlian')->nullable();

            $table->enum('jenis_pendaftaran', [
                'Siswa Baru',
                'Pindahan',
                'Kembali Bersekolah'
            ]);

            $table->string('sekolah_asal')->nullable();

            $table->enum('pernah_paud', [
                'Ya',
                'Tidak'
            ])->default('Tidak');

            $table->string('hobi')->nullable();
            $table->string('cita_cita')->nullable();

            $table->enum('status_registrasi', [
                'Menunggu Verifikasi',
                'Diterima',
                'Ditolak'
            ])->default('Menunggu Verifikasi');

            $table->string('kk')->nullable();

            $table->string('ktp_ortu')->nullable();

            $table->string('akta_kelahiran')->nullable();

            $table->string('surat_keterangan_lulus')->nullable();

            $table->string('kartu_kesejahteraan')->nullable();

            $table->string('sptjm')->nullable();

            $table->string('surat_pernyataan_tata_tertib')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrasi_peserta_didik');
    }
};
