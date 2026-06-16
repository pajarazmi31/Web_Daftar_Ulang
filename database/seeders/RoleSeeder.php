<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('role')->insert([
            [
                'id' => 1,
                'nama_role' => 'admin',
            ],
            [
                'id' => 2,
                'nama_role' => 'operator',
            ],
            [
                'id' => 3,
                'nama_role' => 'kepsek',
            ],
        ]);
    }
}