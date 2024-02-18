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
                'slug' => 'staff',
                'salary' => 3_000_000
            ],
            [
                'name' => 'Supervisor',
                'slug' => 'supervisor',
                'salary' => 3_500_000
            ],
            [
                'name' => 'Manager',
                'slug' => 'manager',
                'salary' => 3_800_000
            ],
            [
                'name' => 'Director',
                'slug' => 'director',
                'salary' => 4_500_000
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
