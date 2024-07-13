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
                'salary' => 150_000,
                'eat_allowance' => 10_000,
                'transport_allowance' => 10_000,
                'position_type_id' => 1,
                'department_id' => 1
            ],
            [
                'name' => 'Komisaris',
                'slug' => 'komisaris',
                'salary' => 100_000,
                'eat_allowance' => 5_000,
                'transport_allowance' => 5_000,
                'position_type_id' => 1,
                'department_id' => 1
            ],
            [
                'name' => 'Ahli K3 Konstruksi',
                'slug' => 'ahli-k3-konstruksi',
                'salary' => 100_000,
                'eat_allowance' => 5_000,
                'transport_allowance' => 5_000,
                'position_type_id' => 1,
                'department_id' => 1
            ],
            [
                'name' => 'Tenaga Ahli Jalan',
                'slug' => 'tenaga-ahli-jalan',
                'salary' => 100_000,
                'eat_allowance' => 5_000,
                'transport_allowance' => 5_000,
                'position_type_id' => 1,
                'department_id' => 1
            ],
            [
                'name' => 'Tenaga Ahli Irigasi',
                'slug' => 'tenaga-ahli-irigasi',
                'salary' => 100_000,
                'eat_allowance' => 5_000,
                'transport_allowance' => 5_000,
                'position_type_id' => 1,
                'department_id' => 1
            ],
            [
                'name' => 'Pelaksana Lapangan',
                'slug' => 'pelaksana-lapangan',
                'salary' => 80_000,
                'eat_allowance' => 5_000,
                'transport_allowance' => 5_000,
                'position_type_id' => 2,
                'department_id' => 1
            ],
            [
                'name' => 'General Superintedent',
                'slug' => 'general-superintedent',
                'salary' => 100_000,
                'eat_allowance' => 5_000,
                'transport_allowance' => 5_000,
                'position_type_id' => 2,
                'department_id' => 1
            ],
            [
                'name' => 'Quality dan Quantity',
                'slug' => 'quality-dan-quantity',
                'salary' => 100_000,
                'eat_allowance' => 5_000,
                'transport_allowance' => 5_000,
                'position_type_id' => 2,
                'department_id' => 1
            ],
            [
                'name' => 'Administrasi',
                'slug' => 'administrasi',
                'salary' => 80_000,
                'eat_allowance' => 5_000,
                'transport_allowance' => 5_000,
                'position_type_id' => 2,
                'department_id' => 1
            ]
        ];

        foreach ($positions as $position) {
            \App\Models\Position::factory()->create([
                'name' => $position['name'],
                'slug' => $position['slug'],
                'department_id' => $position['department_id'],
                'salary' => $position['salary'],
                'eat_allowance' => $position['eat_allowance'],
                'transport_allowance' => $position['transport_allowance'],
                'position_type_id' => $position['position_type_id'],
                'created_by' => 'Salyma Dewi',
            ]);
        }
    }
}
