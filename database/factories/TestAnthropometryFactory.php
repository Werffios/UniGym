<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TestAnthropometry>
 */
class TestAnthropometryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Medida de la circunferencia del bicep
            'bicepCircumference' => $this->faker->randomFloat(2, 15, 40),

            // Medida de la circunferencia del tricep
            'tricepCircumference' => $this->faker->randomFloat(2, 15, 40),

            // Perímetro del carpo
            'carpusPerimeter' => $this->faker->randomFloat(2, 15, 40),

            // Subescapular
            'subscapular' => $this->faker->randomFloat(2, 15, 40),

            // Suprailíaco
            'suprailiac' => $this->faker->randomFloat(2, 15, 40),

            // Porcentaje de grasa
            'fatPercentage' => $this->faker->randomFloat(2, 15, 40),

            // IMC (body mass index)
            'IMC' => $this->faker->randomFloat(2, 15, 40),

            // Valoración de IMC
            'IMCEvaluation' => $this->faker->randomElement(["Bajo peso", "Normal", "Sobrepeso", "Obesidad"]),

            // PesoSaludable
            'healthyWeight' => $this->faker->numberBetween(45, 120),

            // Añade las columnas de llave foránea
            // Foranea de la tabla clients
            'client_id' => $this->faker->numberBetween(1, Client::class::all()->count()),

            //fecha de la medición
            'date' => $this->faker->date(),
        ];
    }
}
