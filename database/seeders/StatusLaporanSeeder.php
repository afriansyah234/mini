<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StatusLaporan;

class StatusLaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
    {
        $statuses = [
            ['statuslaporan' => 'sedang di cek'],
            ['statuslaporan' => 'ditolak'],
            ['statuslaporan' => 'selesai'],
        ];

        foreach ($statuses as $status) {
            StatusLaporan::create($status);
        }
    }
}
