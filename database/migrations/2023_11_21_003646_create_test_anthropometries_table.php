<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('test_anthropometries', function (Blueprint $table) {
            $table->id();

            // Medida de la circunferencia del bicep
            $table->float('bicepCircumference');

            // Medida de la circunferencia del tricep
            $table->float('tricepCircumference');

            // Perímetro del carpo
            $table->float('carpusPerimeter');

            // Subescapular
            $table->float('subscapular');

            // Suprailíaco
            $table->float('suprailiac');


            // Campos generados por triggers

                // Porcentaje de grasa
                $table->string('fatPercentage')->nullable();

                // IMC (body mass index)
                $table->string('IMC')->nullable();

                // Valoración de IMC
                $table->string('IMCEvaluation')->nullable();

                // PesoSaludable
                $table->string('healthyWeight')->nullable();

            //fecha de la medición
            $table->date('date')->nullable();

            // Añade las columnas de llave foránea
            $table->unsignedBigInteger('client_id');

            // Crea las restricciones de llave foránea
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

            $table->timestamps();
        });

        // Trigger para calcular el IMC
        DB::unprepared('

            CREATE TRIGGER `calculatecamps` BEFORE INSERT ON `test_anthropometries` FOR EACH ROW
            BEGIN
                DECLARE client_height DOUBLE;
                DECLARE client_weight DOUBLE;

                SET NEW.date = CURDATE();

                SET NEW.fatPercentage = Round((1.2 * NEW.subscapular) + (0.23 * NEW.tricepCircumference) + (0.8 * NEW.suprailiac) + (0.8 * NEW.bicepCircumference) + (0.6 * NEW.carpusPerimeter), 2);
                -- VERIFICAR FORMULA

                SELECT height, weight INTO client_height, client_weight
                FROM clients
                WHERE clients.id = NEW.client_id;

                SET NEW.IMC = Round((client_weight / (client_height/100 * client_height/100)), 2);

                IF NEW.IMC < 18.5 THEN
                    SET NEW.IMCEvaluation = "Peso insuficiente";
                ELSEIF NEW.IMC >= 18.5 AND NEW.IMC <= 24.9 THEN
                    SET NEW.IMCEvaluation = "Peso normal";
                ELSEIF NEW.IMC >= 25 AND NEW.IMC <= 26.9 THEN
                    SET NEW.IMCEvaluation = "Sobrepeso grado I";
                ELSEIF NEW.IMC >= 27 AND NEW.IMC <= 29.9 THEN
                    SET NEW.IMCEvaluation = "Sobrepeso grado II (pre-obesidad)";
                ELSEIF NEW.IMC >= 30 AND NEW.IMC <= 34.9 THEN
                    SET NEW.IMCEvaluation = "Obesidad de tipo I";
                ELSEIF NEW.IMC >= 35 AND NEW.IMC <= 39.9 THEN
                    SET NEW.IMCEvaluation = "Obesidad de tipo II";
                ELSEIF NEW.IMC >= 40 AND NEW.IMC <= 49.9 THEN
                    SET NEW.IMCEvaluation = "Obesidad de tipo III (mórbida)";
                ELSEIF NEW.IMC >= 50 THEN
                    SET NEW.IMCEvaluation = "Obesidad de tipo IV (extrema)";
                END IF;

                SET NEW.healthyWeight = Round((client_height/100 * client_height/100) * 22, 2);
            END

            '
            );

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   // Elimina el disparador
        DB::unprepared("DROP TRIGGER IF EXISTS calculatecamps");
        Schema::dropIfExists('test_anthropometries');

    }
};
