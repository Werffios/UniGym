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
            // Peso levantado en el ejercicio de press de banca plana y repeticiones
            'benchPress' => $this->faker->numberBetween(2, 10)*10,
            'benchPressReps' => $this->faker->numberBetween(1, 10),

            // Pesos levantados en el ejercicio de polea alta abierta y repeticiones
            'pulleyOpenHigh' => $this->faker->numberBetween(2, 10)*10,
            'pulleyOpenHighReps' => $this->faker->numberBetween(1, 10),

            // Pesos levantados en el ejercicio de curl de bíceps con barra y repeticiones
            'barbellBicepsCurl' => $this->faker->numberBetween(1, 4)*5,
            'barbellBicepsCurlReps' => $this->faker->numberBetween(1, 10),

            // Pesos levantados en el ejercicio de flexión de piernas y repeticiones
            'legFlexion' => $this->faker->numberBetween(10, 20)*10,
            'legFlexionReps' => $this->faker->numberBetween(1, 10),

            // Pesos levantados en el ejercicio de extensión de piernas y repeticiones
            'legExtension' => $this->faker->numberBetween(10, 20)*10,
            'legExtensionReps' => $this->faker->numberBetween(1, 10),

            // Pesos levantados en el ejercicio de flex-ext de piernas y repeticiones
            'legFlexExt' => $this->faker->numberBetween(10, 20)*10,
            'legFlexExtReps' => $this->faker->numberBetween(1, 10),

            // Campo que almacena el resumen del tren superior, es decir, los resultados de los ejercicios de tren superior (brazos, hombros, espalda, pecho)
            'upperLimbs' => $this->faker->numberBetween(5, 10),

            // Campo que almacena el resumen del tren inferior, es decir, los resultados de los ejercicios de tren inferior (piernas, glúteos)
            'lowerLimbs' => $this->faker->numberBetween(5, 10),

            // Campo que almacena la relación entre el tren superior y el inferior, es decir, los resultados de los ejercicios de tren superior (brazos, hombros, espalda, pecho) y tren inferior (piernas, glúteos)
            'relationUpperLowerLimbs' => $this->faker->numberBetween(40, 60),

            // Fecha en la que se realiza el test de fuerza
            'date' => $this->faker->dateTimeBetween('-2 years', 'now'),

            // Añade las columnas de llave foránea del cliente
            'client_id' => $this->faker->numberBetween(1, Client::class::all()->count()),
        ];
    }
}
