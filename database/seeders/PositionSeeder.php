<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            [
                'name' => 'Staff',
                'slug' => 'staff'
            ],
            [
                'name' => 'Supervisor',
                'slug' => 'supervisor'
            ],
            [
                'name' => 'Manager',
                'slug' => 'manager'
            ],
            [
                'name' => 'Director',
                'slug' => 'director'
            ],
        ];

        foreach ($positions as $position) {
            \App\Models\Position::factory()->create([
                'name' => $position['name'],
                'slug' => $position['slug'],
                'department_id' => 1,
            ]);
        }
    }
}
