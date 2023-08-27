<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName(),
            'surname' => $this->faker->lastName(),
            'document' => $this->faker->unique()->randomNumber(9),
            'height' => $this->faker->numberBetween(150, 185),
            'weight' => $this->faker->numberBetween(50, 100),
            'birth_date' => $this->faker->dateTimeBetween('-50 years', '-16 years'),
        ];
    }
}
