<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pay>
 */
class PayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start_date' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 years'),
            'client_id' => $this->faker->unique()->numberBetween(1, Client::all()->count()),
            'amount' => $this->faker->randomElement([0, 10000, 20000, 50000, 70000]),
            ];
    }
}
