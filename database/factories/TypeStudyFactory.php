<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\degree;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\type_study>
 */
class TypeStudyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'degree_id' => $this->faker->numberBetween(1, degree::all()->count()),
            'client_id' => $this->faker->numberBetween(1, Client::all()->count()),
        ];
    }
}
