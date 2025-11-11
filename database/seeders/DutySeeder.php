<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Duty;

class DutySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Duty::create([
            'section' => 'Kebersihan',
            'description' => 'Tugas menjaga kebersihan lingkungan asrama.',
        ]);

        Duty::create([
            'section' => 'Keamanan',
            'description' => 'Tugas menjaga keamanan dan ketertiban asrama.',
        ]);

        Duty::create([
            'section' => 'Konsumsi',
            'description' => 'Tugas membantu persiapan dan distribusi konsumsi.',
        ]);
    }
}