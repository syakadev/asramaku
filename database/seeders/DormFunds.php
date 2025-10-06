<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DormFund;


class DormFunds extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DormFund::create([
            'title' => 'Pemasukan Kas Bulanan',
            'balance' => 100000.00,
            'date' => '2024-01-01',
            'status' => 'pemasukan',
            'user_id' => 1,
        ]);

        DormFund::create([
            'title' => 'Pembelian Alat Kebersihan',
            'balance' => 50000.00,
            'date' => '2024-01-15',
            'status' => 'pengeluaran',
            'user_id' => 1,
        ]);

        DormFund::create([
            'title' => 'Pemasukan Donasi',
            'balance' => 200000.00,
            'date' => '2024-02-01',
            'status' => 'pemasukan',
            'user_id' => 1,
        ]);

    }
}
