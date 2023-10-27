<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\type_document>
 */
class TypeDocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement(['Cédula de Ciudadanía', 'Cédula de Extranjería', 'Tarjeta de Identidad', 'Registro Civil', 'Pasaporte']),
        ];
    }
}
