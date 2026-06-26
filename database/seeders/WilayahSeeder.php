<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan foreign key check sementara agar proses insert data cepat & lancar
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 1. PROVINSI
        $this->command->info('Sedang mengimpor data Provinsi...');
        $fileProv = fopen(database_path('csv/provinces.csv'), 'r');
        while (($data = fgetcsv($fileProv, 2000, ",")) !== FALSE) {
            DB::table('provinsis')->insert([
                'id'   => $data[0],
                'nama' => ucwords(strtolower(trim($data[1]))),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        fclose($fileProv);

        // 2. KABUPATEN
        $this->command->info('Sedang mengimpor data Kabupaten...');
        $fileKab = fopen(database_path('csv/regencies.csv'), 'r');
        while (($data = fgetcsv($fileKab, 2000, ",")) !== FALSE) {
            DB::table('kabupatens')->insert([
                'id'          => $data[0],
                'provinsi_id' => $data[1],
                'nama'        => ucwords(strtolower(trim($data[2]))),
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
        fclose($fileKab);

        // 3. KECAMATAN
        $this->command->info('Sedang mengimpor data Kecamatan...');
        $fileKec = fopen(database_path('csv/districts.csv'), 'r');
        while (($data = fgetcsv($fileKec, 2000, ",")) !== FALSE) {
            DB::table('kecamatans')->insert([
                'id'           => $data[0],
                'kabupaten_id' => $data[1],
                'nama'         => ucwords(strtolower(trim($data[2]))),
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
        fclose($fileKec);

        // 4. DESA (Data sangat besar, kita gunakan chunking/batching array agar memori laptop tidak jebol)
        $this->command->info('Sedang mengimpor data Desa (Mohon tunggu sebentar)...');
        $fileDesa = fopen(database_path('csv/villages.csv'), 'r');
        $batchData = [];
        $counter = 0;

        while (($data = fgetcsv($fileDesa, 2000, ",")) !== FALSE) {
            $batchData[] = [
                'id'           => $data[0],
                'kecamatan_id' => $data[1],
                'nama'         => ucwords(strtolower(trim($data[2]))),
                'created_at'   => now(),
                'updated_at'   => now(),
            ];
            $counter++;

            // Setiap 2000 baris, langsung tembak insert ke DB agar hemat RAM
            if ($counter % 2000 === 0) {
                DB::table('desas')->insert($batchData);
                $batchData = []; // Kosongkan penampung
            }
        }

        // Jalankan sisa data yang belum ter-insert
        if (count($batchData) > 0) {
            DB::table('desas')->insert($batchData);
        }
        fclose($fileDesa);

        // Aktifkan kembali foreign key check
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->command->info('Sukses! Seluruh data wilayah Indonesia berhasil diimpor.');
    }
}