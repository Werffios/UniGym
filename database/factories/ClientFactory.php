<?php

namespace Database\Factories;

use App\Models\type_client;
use App\Models\type_document;
use App\Models\type_study;
use App\Models\type_status;

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
            'document' => $this->faker->unique()->randomNumber(9),
            'name' => $this->faker->firstName(),
            'surname' => $this->faker->lastName(),
            'height' => $this->faker->numberBetween(150, 185),
            'weight' => $this->faker->numberBetween(50, 100),
            'gender' => $this->faker->randomElement(['Masculino', 'Femenino']),
            'birth_date' => $this->faker->dateTimeBetween('-50 years', '-16 years'),
            'active' => $this->faker->boolean(),


            'type_client_id' => $this->faker->numberBetween(1, type_client::all()->count()),
            'type_document_id' => $this->faker->numberBetween(1, type_document::all()->count()),

        ];
    }
}
