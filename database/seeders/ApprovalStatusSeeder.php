<?php

namespace Database\Seeders;

use App\Models\ApprovalStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApprovalStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'name' => 'Disetujui',
                'description' => 'Pengajuan anda memenuhi syarat dan telah disetujui'
            ],
            [
                'name' => 'Menunggu Persetujuan',
                'description' => 'Pengajuan anda diterima dan menunggu persetujuan'
            ],
            [
                'name' => 'Ditolak',
                'description' => 'Pengajuan anda ditolak karena tidak memenuhi ketentuan!'
            ],
        ];

        foreach ($statuses as $status) {
            ApprovalStatus::factory()->create([
                'name' => $status['name'],
                'description' => $status['description'],
            ]);
        }
    }
}
