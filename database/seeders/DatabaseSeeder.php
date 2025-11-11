<?php

namespace Database\Seeders;

use App\Models\Infraction;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void {
        User::create([
            'name' => 'Admin User',
            'phone' => '08732147324',
            'dorm' => '1',
            'role' => 'admin',
            'password' => bcrypt('password'),
        ]);

        $this->call(
            [
                InfractionSeeder::class,
                DormFundSeeder::class,
                DutySeeder::class
            ]
        );


    }
}
