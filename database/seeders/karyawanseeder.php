<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Karyawan;

class karyawanseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Karyawan::insert([
            [
                'nama_karyawan' => 'Andi Saputra',
                'email' => 'andi@example.com',
                'departemen_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_karyawan' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'departemen_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_karyawan' => 'Citra Dewi',
                'email' => 'citra@example.com',
                'departemen_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
