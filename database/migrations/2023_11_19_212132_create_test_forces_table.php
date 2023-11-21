<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('test_forces', function (Blueprint $table) {
            $table->id();

            //Peso levantado en el ejercicio de press de banca plana y repeticiones
            $table->string('benchPress');
            $table->string('benchPressReps');

            //Pesos levantados en el ejercicio de polea alta abierta y repeticiones
            $table->string('pulleyOpenHigh');
            $table->string('pulleyOpenHighReps');

            //Pesos levantados en el ejercicio de curl de bíceps con barra y repeticiones
            $table->string('barbellBicepsCurl');
            $table->string('barbellBicepsCurlReps');

            //Pesos levantados en el ejercicio de flexión de piernas y repeticiones
            $table->string('legFlexion');
            $table->string('legFlexionReps');

            //Pesos levantados en el ejercicio de extensión de piernas y repeticiones
            $table->string('legExtension');
            $table->string('legExtensionReps');

            //Pesos levantados en el ejercicio de flex-ext de piernas y repeticiones
            $table->string('legFlexExt');
            $table->string('legFlexExtReps');

            // Campo que almacena el resumen del tren superior, es decir, los resultados de los ejercicios de tren superior (brazos, hombros, espalda, pecho)
            $table->string('upperLimbs')->nullable();

            // Campo que almacena el resumen del tren inferior, es decir, los resultados de los ejercicios de tren inferior (piernas, glúteos)
            $table->string('lowerLimbs')->nullable();

            // Campo que almacena la relación entre el tren superior y el inferior, es decir, los resultados de los ejercicios de tren superior (brazos, hombros, espalda, pecho) y tren inferior (piernas, glúteos)
            $table->string('relationUpperLowerLimbs')->nullable();

            $table->date('date')->nullable();

            // Añade las columnas de llave foránea
            $table->unsignedBigInteger('client_id');

            // Crea las restricciones de llave foránea
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_forces');
    }
};
