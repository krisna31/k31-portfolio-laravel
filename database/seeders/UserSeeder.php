<?php

namespace Database\Seeders;

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
            'name' => 'Jelvin Krisna Putra',
            'email' => 'krisnaaaputraaa@gmail.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);
    }
}
