<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\type_client>
 */
class TypeClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement(['Estudiante', 'Egresado', 'Docente', 'Administrativo']),
            'fee' => $this->faker->randomElement([100000, 150000, 200000, 250000]),
            'months' => $this->faker->randomElement([1, 3, 6, 12]),

        ];
    }
}
