<?php

namespace Database\Seeders;

use App\Models\AttendeStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendeStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // * https://www.gramedia.com/literasi/pengertian-cuti-jenis-jenis-hingga-undang-undang-cuti/#Undang-Undang_Terkait_Cuti_Karyawan
        // * https://peraturan.bpk.go.id/Details/43013
        $data = [
            'Hadir',
            'Terlambat',
            'Cuti Sakit',
            'Cuti Tahunan',
            'Cuti Besar',
            'Cuti Hari Raya',
            'Cuti Bersama',
            'Cuti Haid',
            'Cuti Hamil Dan Melahirkan',
            'Cuti Dengan Alasan Penting',
            'Cuti Menikah',
        ];

        foreach ($data as $status) {
            AttendeStatus::factory()->create(
                [
                    'name' => $status,
                    'description' => str()->slug($status),
                    'created_by' => 'Seeder',
                ]
            );
        }
    }
}
