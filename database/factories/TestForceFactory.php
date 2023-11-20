<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Client;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TestForce>
 */
class TestForceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'upperLimbs' => $this->faker->randomNumber(2),
            'lowerLimbs' => $this->faker->randomNumber(2),
            'relationUpperLowerLimbs' => $this->faker->randomNumber(2),
            'date' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'client_id' => $this->faker->numberBetween(1, Client::class::all()->count()),
        ];
    }
}
