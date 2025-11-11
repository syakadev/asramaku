<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DormFund;


class DormfundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DormFund::create([
            'title' => 'Pemasukan Kas Bulanan',
            'amount' => 100000.00,
            'date' => '2024-01-01',
            'status' => 'pemasukan',
            'type' => 'kas',
            'user_id' => 1,
        ]);

        DormFund::create([
            'title' => 'Denda tidak piket',
            'amount' => 5000.00,
            'date' => '2024-01-15',
            'status' => 'pemasukan',
            'type' => 'denda',
            'infraction_id' => 1,
            'user_id' => 1,
        ]);

        DormFund::create([
            'title' => 'Pembelian Alat Kebersihan',
            'amount' => 50000.00,
            'date' => '2024-01-15',
            'status' => 'pengeluaran',
            'type' => 'kas',
            'user_id' => 1,
        ]);

        DormFund::create([
            'title' => 'Pemasukan Donasi',
            'amount' => 200000.00,
            'date' => '2024-02-01',
            'status' => 'pemasukan',
            'type' => 'kas',
            'user_id' => 1,
        ]);

    }
}
