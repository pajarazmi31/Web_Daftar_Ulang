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
        Schema::create('peserta_didik', function (Blueprint $table) {
            $table->id();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('nomor_pendaftaran')->unique()->nullable();

            // DATA PRIBADI
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);

            $table->string('nisn', 20)->nullable();
            $table->string('nik', 20);
            $table->string('no_kk', 20);

            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');

            $table->string('no_registrasi_akta')->nullable();

            $table->enum('agama', [
                'Islam',
                'Kristen Protestan',
                'Katolik',
                'Hindu',
                'Buddha',
                'Khonghucu',
                'Kepercayaan Kepada Tuhan YME'
            ]);
            $table->enum('kewarganegaraan', [
                'WNI',
                'WNA'
            ])->default('WNI');
            $table->string('negara_asal')->nullable();

            $table->text('berkebutuhan_khusus')->nullable();

            $table->text('alamat');

            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();

            $table->string('dusun')->nullable();
            $table->string('desa_kelurahan');
            $table->string('kecamatan');
            $table->string('kode_pos')->nullable();

            $table->string('lintang')->nullable();
            $table->string('bujur')->nullable();

            $table->enum('tempat_tinggal', [
                'Bersama Orang Tua',
                'Wali',
                'Kos',
                'Asrama',
                'Panti Asuhan'
            ])->nullable();
            $table->enum('moda_transportasi', [
                'Jalan Kaki',
                'Kendaraan Pribadi',
                'Kendaraan Umum',
                'Jemputan Sekolah',
                'Kereta Api',
                'Ojek',
                'Andong/Bendi/Sado/Dokar/Delman/Beca',
                'Perahu Penyeberangan/Rakit/Getek',
                'Lainnya'
            ])->nullable();

            $table->unsignedTinyInteger('anak_ke')->nullable();

            $table->enum('pekerjaan_siswa', [
                'Tidak Bekerja',
                'Nelayan',
                'Petani',
                'Peternak',
                'PNS/TNI/POLRI',
                'Karyawan Swasta',
                'Pedagang Kecil',
                'Pedagang Besar',
                'Wiraswasta',
                'Wirausaha',
                'Buruh',
                'Pensiunan'
            ])->nullable();

            $table->boolean('punya_kip')->default(false);
            $table->boolean('penerima_kip')->default(false);

            // DATA AYAH
            $table->string('nama_ayah')->nullable();
            $table->string('nik_ayah', 20)->nullable();
            $table->year('tahun_lahir_ayah')->nullable();
            $table->enum('pendidikan_ayah', [
                'Tidak Sekolah',
                'Putus SD',
                'SD/Sederajat',
                'SMP/Sederajat',
                'SMA/Sederajat',
                'D1',
                'D2',
                'D3',
                'D4/S1',
                'S2',
                'S3'
            ])->nullable();
            $table->enum('pekerjaan_ayah', [
                'Tidak Bekerja',
                'Nelayan',
                'Petani',
                'Peternak',
                'PNS/TNI/POLRI',
                'Karyawan Swasta',
                'Pedagang Kecil',
                'Pedagang Besar',
                'Wiraswasta',
                'Wirausaha',
                'Buruh',
                'Pensiunan',
                'Meninggal Dunia'
            ])->nullable();
            $table->enum('penghasilan_ayah', [
                '< 500.000',
                '500.000 - 999.999',
                '1.000.000 - 1.999.999',
                '2.000.000 - 4.999.999',
                '5.000.000 - 20.000.000',
                '> 20.000.000',
                'Tidak Berpenghasilan'
            ])->nullable();
            $table->text('kebutuhan_khusus_ayah')->nullable();

            // DATA IBU
            $table->string('nama_ibu')->nullable();
            $table->string('nik_ibu', 20)->nullable();
            $table->year('tahun_lahir_ibu')->nullable();
            $table->enum('pendidikan_ibu', [
                'Tidak Sekolah',
                'Putus SD',
                'SD/Sederajat',
                'SMP/Sederajat',
                'SMA/Sederajat',
                'D1',
                'D2',
                'D3',
                'D4/S1',
                'S2',
                'S3'
            ])->nullable();
            $table->enum('pekerjaan_ibu', [
                'Tidak Bekerja',
                'Nelayan',
                'Petani',
                'Peternak',
                'PNS/TNI/POLRI',
                'Karyawan Swasta',
                'Pedagang Kecil',
                'Pedagang Besar',
                'Wiraswasta',
                'Wirausaha',
                'Buruh',
                'Pensiunan',
                'Meninggal Dunia'
            ])->nullable();
            $table->enum('penghasilan_ibu', [
                '< 500.000',
                '500.000 - 999.999',
                '1.000.000 - 1.999.999',
                '2.000.000 - 4.999.999',
                '5.000.000 - 20.000.000',
                '> 20.000.000',
                'Tidak Berpenghasilan'
            ])->nullable();
            $table->text('kebutuhan_khusus_ibu')->nullable();

            // DATA WALI
            $table->string('nama_wali')->nullable();
            $table->string('nik_wali', 20)->nullable();
            $table->year('tahun_lahir_wali')->nullable();
            $table->enum('pendidikan_wali', [
                'Tidak Sekolah',
                'Putus SD',
                'SD/Sederajat',
                'SMP/Sederajat',
                'SMA/Sederajat',
                'D1',
                'D2',
                'D3',
                'D4/S1',
                'S2',
                'S3'
            ])->nullable();
            $table->enum('pekerjaan_wali', [
                'Tidak Bekerja',
                'Nelayan',
                'Petani',
                'Peternak',
                'PNS/TNI/POLRI',
                'Karyawan Swasta',
                'Pedagang Kecil',
                'Pedagang Besar',
                'Wiraswasta',
                'Wirausaha',
                'Buruh',
                'Pensiunan',
                'Meninggal Dunia'
            ])->nullable();
            $table->enum('penghasilan_wali', [
                '< 500.000',
                '500.000 - 999.999',
                '1.000.000 - 1.999.999',
                '2.000.000 - 4.999.999',
                '5.000.000 - 20.000.000',
                '> 20.000.000',
                'Tidak Berpenghasilan'
            ])->nullable();

            // KONTAK
            $table->string('no_hp_ortu')->nullable();
            $table->string('no_hp')->nullable();
            $table->string('email')->nullable();

            // DATA PERIODIK
            $table->decimal('tinggi_badan', 5, 2)->nullable();
            $table->decimal('berat_badan', 5, 2)->nullable();

            $table->enum('jarak_sekolah', [
                'Kurang dari 1 km',
                'Lebih dari 1 km'
            ])->nullable();

            $table->decimal('jarak_kilometer', 8, 2)->nullable();
            $table->integer('waktu_tempuh')->nullable();

            $table->integer('jumlah_saudara')->nullable();

            // BEASISWA
            $table->enum('jenis_beasiswa', [
                'Anak Berprestasi',
                'Anak Miskin',
                'Pendidikan',
                'Unggulan'
            ])->nullable();
            $table->string('keterangan_beasiswa')->nullable();

            $table->year('tahun_mulai_beasiswa')->nullable();
            $table->year('tahun_selesai_beasiswa')->nullable();

            // KESEJAHTERAAN
            $table->enum('jenis_kesejahteraan', [
                'PKH',
                'PIP',
                'Kartu Perlindungan Sosial',
                'Kartu Keluarga Sejahtera',
                'Kartu Kesehatan'
            ])->nullable();
            $table->string('nomor_kartu_kesejahteraan')->nullable();
            $table->string('nama_pemegang_kartu')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peserta_didik');
    }
};
