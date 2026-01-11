<?php

namespace Database\Seeders;

use App\Models\daftar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DaftarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        daftar::factory(count:50)->create();
    }
}
