<?php

namespace Database\Seeders;

use App\Models\pasien;
use App\Models\daftar;
use App\Models\poli;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Pasien::factory()->count(50)->create();
        poli::factory()->count(50)->create();
        daftar::factory()->count(50)->create();

    }
}
