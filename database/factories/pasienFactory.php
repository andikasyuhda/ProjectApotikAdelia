<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pasien>
 */
class pasienFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'no_pasien'=>fake()->unique()->randomNumber(nbDigits:8),
            'nama' =>fake()->name(),
            'umur' =>fake()->numberBetween(int1: 20, int2: 50),
            'jenis_kelamin' => fake()->randomElement(array: ['Laki-laki', 'Perempuan']),
            'alamat' => fake()->address(),
            'foto' => null,
        ];
    }
}
