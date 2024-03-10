<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positionTypes = [
            [
                'name' => 'Pegawai Kantor',
                'description' => 'Pegawai yang bekerja di kantor',
            ],
            [
                'name' => 'Pegawai Lapangan',
                'description' => 'Pegawai yang bekerja di lapangan',
            ],
        ];

        foreach ($positionTypes as $positionType) {
            \App\Models\PositionType::create($positionType);
        }
    }
}
