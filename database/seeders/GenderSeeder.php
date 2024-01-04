<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genders = [
            [
                'name' => 'Pria',
                'slug' => 'pria'
            ],
            [
                'name' => 'Wanita',
                'slug' => 'wanita'
            ],
        ];

        foreach ($genders as $gender) {
            Gender::factory()->create([
                'name' => $gender['name'],
                'slug' => $gender['slug'],
            ]);
        }
    }
}
