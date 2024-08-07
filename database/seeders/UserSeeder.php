<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'id' => 0,
            'name' => 'All Users',
            'email' => 'alluserpreserved@k31.com',
            'gender_id' => 1,
            'position_id' => Position::all()->random()->id,
            'password' => bcrypt(str()->uuid()),
            'created_by' => 'Superadministrator',
        ]);

        User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo@k31.com',
            'gender_id' => 1,
            'position_id' => Position::all()->random()->id,
            'password' => bcrypt('demo@k31.com'),
            'created_by' => 'Superadministrator',
        ]);
    }
}
