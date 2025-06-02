<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\StatusProject;

class StatusProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['status_project' => 'perencanaan'],
            ['status_project' => 'berjalan'],
            ['status_project' => 'ditunda'],
            ['status_project' => 'selesai']
        ];

        foreach ($statuses as $status) {
            Statusproject::create($status);
        }
    }
}
