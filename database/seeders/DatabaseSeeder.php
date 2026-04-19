<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (!User::where('email', 'admin@sipastob-ab.com')->exists()) {
            User::create([
                'name'     => 'Admin SIPASTOB-AB',
                'email'    => 'admin@sipastob-ab.com',
                'password' => Hash::make('S!p4st0b@2026#AB'),
            ]);
        }

        $this->call([
            MedicineSeeder::class,
        ]);
    }
}
