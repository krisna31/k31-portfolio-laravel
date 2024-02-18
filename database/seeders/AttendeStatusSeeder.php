<?php

namespace Database\Seeders;

use App\Models\AttendeStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendeStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Hadir',
            'Izin Sakit',
            'Cuti Tahunan',
            'Cuti Bersalin',
        ];

        foreach ($data as $status) {
            AttendeStatus::factory()->create(
                [
                    'name' => $status,
                    'description' => str()->slug($status)
                ]
            );
        }
    }
}
