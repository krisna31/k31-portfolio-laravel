<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'Human Resource',
            'Finance',
            'Marketing',
            'Information Technology',
            'Sales',
            'Production',
            'Research and Development',
            'Customer Service',
            'Legal',
            'Quality Assurance',
        ];

        foreach ($departments as $department) {
            \App\Models\Department::factory()->create([
                'name' => $department,
                'slug' => \Illuminate\Support\Str::slug($department),
            ]);
        }
    }
}
