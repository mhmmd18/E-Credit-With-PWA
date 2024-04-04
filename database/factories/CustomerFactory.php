<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'address' => fake()->randomElement(['Bakalan', 'Babatan','Lojok', 'Petung', 'Buaran', 'Bandaran', 'Lajuk', 'Jajar']),
            'gender' => fake()->randomElement(['L', 'P']),
            'phone' => fake()->phoneNumber(),
            'type' => fake()->randomElement(['Harian', 'Mingguan', 'Bulanan']),
            'debt' => fake()->randomNumber(7, true),
            'status' => fake()->randomElement(['Lunas', 'Belum Lunas']),
            'items' => fake()->name(),
        ];

    }
}
