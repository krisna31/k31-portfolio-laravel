<?php

namespace Database\Seeders;

use App\Models\AttendeType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Absen Pagi',
            'Absen Istrahat',
            'Absen Pulang',
            'Absen Lembur',
            'Absen Perjalanan Dinas',
        ];

        foreach ($types as $type) {
            AttendeType::factory()->create(
                [
                    'name' => $type,
                    'slug' => str()->slug($type)
                ]
            );
        }
    }
}
