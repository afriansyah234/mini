<?php

namespace Database\Seeders;

use App\Models\Status_tugas;
use Illuminate\Database\Seeder;

class StatusTugasSeeder extends Seeder
{
    public function run()
    {
        $statuses = [
            ['nama_status' => 'belum dimulai'],
            ['nama_status' => 'dalam pengerjaan'],
            ['nama_status' => 'menunggu review'],
            ['nama_status' => 'selesai'],
            ['nama_status' => 'telat']
        ];

        foreach ($statuses as $status) {
            Status_tugas::create($status);
        }
    }
}