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
            'name' => 'K31 Project Manager',
            'email' => 'k31@manager.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);
    }
}
