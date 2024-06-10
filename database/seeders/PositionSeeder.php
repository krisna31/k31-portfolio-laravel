<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        /**
         * Direktur
            Komisaris
            Ahli K3 Konstruksi
            Tenaga Ahli Jalan
            Tenaga Ahli Irigasi
            Pelaksana Lapangan
            General Superintedent
            Quality dan Quantity
            Administrasi
         */
        $positions = [
            [
                'name' => 'Direktur',
                'slug' => 'direktur',
                'salary' => 6_000_000,
                'position_type_id' => 1,
            ],
            [
                'name' => 'Komisaris',
                'slug' => 'komisaris',
                'salary' => 4_000_000,
                'position_type_id' => 1,
            ],
            [
                'name' => 'Ahli K3 Konstruksi',
                'slug' => 'ahli-k3-konstruksi',
                'salary' => 3_500_000,
                'position_type_id' => 1,
            ],
            [
                'name' => 'Tenaga Ahli Jalan',
                'slug' => 'tenaga-ahli-jalan',
                'salary' => 3_500_000,
                'position_type_id' => 1,
            ],
            [
                'name' => 'Tenaga Ahli Irigasi',
                'slug' => 'tenaga-ahli-irigasi',
                'salary' => 3_500_000,
                'position_type_id' => 1,
            ],
            [
                'name' => 'Pelaksana Lapangan',
                'slug' => 'pelaksana-lapangan',
                'salary' => 3_000_000,
                'position_type_id' => 2,
            ],
            [
                'name' => 'General Superintedent',
                'slug' => 'general-superintedent',
                'salary' => 3_000_000,
                'position_type_id' => 2,
            ],
            [
                'name' => 'Quality dan Quantity',
                'slug' => 'quality-dan-quantity',
                'salary' => 3_000_000,
                'position_type_id' => 2,
            ],
            [
                'name' => 'Administrasi',
                'slug' => 'administrasi',
                'salary' => 3_000_000,
                'position_type_id' => 1,
            ]
        ];

        foreach ($positions as $position) {
            \App\Models\Position::factory()->create([
                'name' => $position['name'],
                'slug' => $position['slug'],
                'department_id' => 1,
                'salary' => $position['salary'],
                'position_type_id' => $position['position_type_id'],
            ]);
        }
    }
}
