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
                'created_by' => 'Salyma Dewi',
            ],
            [
                'name' => 'Pegawai Lapangan',
                'description' => 'Pegawai yang bekerja di lapangan',
                'created_by' => 'Salyma Dewi',
            ],
        ];

        foreach ($positionTypes as $positionType) {
            \App\Models\PositionType::create($positionType);
        }
    }
}
