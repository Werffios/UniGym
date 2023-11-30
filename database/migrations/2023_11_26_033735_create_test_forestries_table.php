<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('test_forestries', function (Blueprint $table) {
            $table->id();

            //Pulso en reposo
            $table->integer('restingPulse')->nullable(); //74
            //Pulso en esfuerzo
            $table->integer('effortPulse')->nullable(); //156
            //Pulso en recuperación
            $table->integer('recoveryPulse')->nullable(); //132
            // VO2max
            $table->integer('VO2max')->nullable();
            // Valoración VO2max
            $table->string('VO2maxEvaluation')->nullable();
            // fecha
            $table->date('date')->nullable();
            // FCmax
            $table->integer('FCmax')->nullable();
            // FCReposo
            $table->integer('FCReposo')->nullable();
            // FCReserva
            $table->integer('FCReserva')->nullable();

            // Añade las columnas de llave foránea
            $table->unsignedBigInteger('client_id');

            // Crea las restricciones de llave foránea
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');


            $table->timestamps();
        });

        // Trigger para calcular el VO2max

        DB::unprepared('

        CREATE TRIGGER tr_calculate_VO2max
BEFORE INSERT ON test_forestries
FOR EACH ROW
BEGIN
    DECLARE edad INTEGER;
    DECLARE VO2max INTEGER;
    DECLARE FCmax INTEGER;
    DECLARE FCReposo INTEGER;
    DECLARE FCReserva INTEGER;
    DECLARE VO2maxEvaluation VARCHAR(50);
    DECLARE gender VARCHAR(10);
    SET edad = (SELECT TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) FROM clients WHERE id = NEW.client_id);
    SET gender = (SELECT gender FROM clients WHERE id = NEW.client_id);
    SET FCmax = 191.5 - (0.007 * edad * edad);
    SET FCReposo = NEW.restingPulse;
    SET FCReserva = FCmax - FCReposo;
    SET VO2max = (15 * FCmax) / FCReposo;
    SET VO2maxEvaluation = CASE
        WHEN gender = "Masculino"
        THEN
            CASE
                WHEN edad BETWEEN 13 AND 19 THEN
                    CASE
                        WHEN VO2max < 35.0 THEN "Very Poor"
                        WHEN VO2max <= 38.3 THEN "Poor"
                        WHEN VO2max <= 45.1 THEN "Fair"
                        WHEN VO2max <= 50.9 THEN "Good"
                        WHEN VO2max <= 55.9 THEN "Excellent"
                        ELSE "Superior"
                    END
                WHEN edad BETWEEN 20 AND 29 THEN
                    CASE
                        WHEN VO2max < 33.0 THEN "Very Poor"
                        WHEN VO2max <= 36.4 THEN "Poor"
                        WHEN VO2max <= 42.4 THEN "Fair"
                        WHEN VO2max <= 46.4 THEN "Good"
                        WHEN VO2max <= 52.4 THEN "Excellent"
                        ELSE "Superior"
                    END
                WHEN edad BETWEEN 30 AND 39 THEN
                    CASE
                        WHEN VO2max < 31.5 THEN "Very Poor"
                        WHEN VO2max <= 35.4 THEN "Poor"
                        WHEN VO2max <= 40.9 THEN "Fair"
                        WHEN VO2max <= 44.9 THEN "Good"
                        WHEN VO2max <= 49.4 THEN "Excellent"
                        ELSE "Superior"
                    END
                WHEN edad BETWEEN 40 AND 49 THEN
                    CASE
                        WHEN VO2max < 30.2 THEN "Very Poor"
                        WHEN VO2max <= 33.5 THEN "Poor"
                        WHEN VO2max <= 38.9 THEN "Fair"
                        WHEN VO2max <= 43.7 THEN "Good"
                        WHEN VO2max <= 48.0 THEN "Excellent"
                        ELSE "Superior"
                    END
                WHEN edad BETWEEN 50 AND 59 THEN
                    CASE
                        WHEN VO2max < 26.1 THEN "Very Poor"
                        WHEN VO2max <= 30.9 THEN "Poor"
                        WHEN VO2max <= 35.7 THEN "Fair"
                        WHEN VO2max <= 40.9 THEN "Good"
                        WHEN VO2max <= 45.3 THEN "Excellent"
                        ELSE "Superior"
                    END
                ELSE
                    CASE
                        WHEN VO2max < 20.5 THEN "Very Poor"
                        WHEN VO2max <= 26.0 THEN "Poor"
                        WHEN VO2max <= 32.2 THEN "Fair"
                        WHEN VO2max <= 36.4 THEN "Good"
                        WHEN VO2max <= 44.2 THEN "Excellent"
                        ELSE "Superior"
                    END
            END
        WHEN gender = "Femenino" THEN
            CASE
                WHEN edad BETWEEN 13 AND 19 THEN
                    CASE
                        WHEN VO2max < 25.0 THEN "Very Poor"
                        WHEN VO2max <= 30.9 THEN "Poor"
                        WHEN VO2max <= 34.9 THEN "Fair"
                        WHEN VO2max <= 38.9 THEN "Good"
                        WHEN VO2max <= 41.9 THEN "Excellent"
                        ELSE "Superior"
                    END
                WHEN edad BETWEEN 20 AND 29 THEN
                    CASE
                        WHEN VO2max < 23.6 THEN "Very Poor"
                        WHEN VO2max <= 28.9 THEN "Poor"
                        WHEN VO2max <= 32.9 THEN "Fair"
                        WHEN VO2max <= 36.9 THEN "Good"
                        WHEN VO2max <= 41.0 THEN "Excellent"
                        ELSE "Superior"
                    END
                WHEN edad BETWEEN 30 AND 39 THEN
                    CASE
                        WHEN VO2max < 22.8 THEN "Very Poor"
                        WHEN VO2max <= 26.9 THEN "Poor"
                        WHEN VO2max <= 31.4 THEN "Fair"
                        WHEN VO2max <= 35.6 THEN "Good"
                        WHEN VO2max <= 40.0 THEN "Excellent"
                        ELSE "Superior"
                    END
                WHEN edad BETWEEN 40 AND 49 THEN
                    CASE
                        WHEN VO2max < 21.0 THEN "Very Poor"
                        WHEN VO2max <= 24.4 THEN "Poor"
                        WHEN VO2max <= 28.9 THEN "Fair"
                        WHEN VO2max <= 32.8 THEN "Good"
                        WHEN VO2max <= 36.9 THEN "Excellent"
                        ELSE "Superior"
                    END
                WHEN edad BETWEEN 50 AND 59 THEN
                    CASE
                        WHEN VO2max < 20.2 THEN "Very Poor"
                        WHEN VO2max <= 22.7 THEN "Poor"
                        WHEN VO2max <= 26.9 THEN "Fair"
                        WHEN VO2max <= 31.4 THEN "Good"
                        WHEN VO2max <= 35.7 THEN "Excellent"
                        ELSE "Superior"
                    END
                ELSE
                    CASE
                        WHEN VO2max < 17.5 THEN "Very Poor"
                        WHEN VO2max <= 20.1 THEN "Poor"
                        WHEN VO2max <= 24.4 THEN "Fair"
                        WHEN VO2max <= 30.2 THEN "Good"
                        WHEN VO2max <= 31.4 THEN "Excellent"
                        ELSE "Superior"
                    END
            END
        ELSE "No se pudo calcular"
        END;
    SET NEW.FCmax = FCmax;
    SET NEW.FCReposo = FCReposo;
    SET NEW.FCReserva = FCReserva;
    SET NEW.VO2max = VO2max;
    SET NEW.VO2maxEvaluation = VO2maxEvaluation;
END;



            '
        );

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS tr_calculate_VO2max");
        Schema::dropIfExists('test_forestries');
    }
};
