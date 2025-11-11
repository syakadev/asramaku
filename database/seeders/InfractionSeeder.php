<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Infraction;

class InfractionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Infraction::create([
            'img' => 'infraction.jpg',
            'note' => 'Tidak piket',
            'date' => '2024-01-01',
            'type' => 'piket',
            'status' => 'dibayar',
            'amount' => 5000.00,
            'reporter_id' => 1,
            'user_id' => 1,
        ]);
    }
}
