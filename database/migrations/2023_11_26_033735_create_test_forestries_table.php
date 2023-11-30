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

        DB::unprepared("

        CREATE TRIGGER after_insert_test_forestries
        before INSERT ON test_forestries
        FOR EACH ROW
        BEGIN
            -- Variables de entrada desde la tabla insertada
            DECLARE edad INT;
            DECLARE genero VARCHAR(255);
            DECLARE n INT;
            -- Variables para la clasificación
            DECLARE clasificacion VARCHAR(255);

            -- hallar genero y guardar en la columna
            SELECT gender INTO genero FROM clients WHERE id = NEW.client_id;

            -- Obtener los valores insertados
            SET n = NEW.VO2max;

            -- Calcular la edad restando la fecha actual y la fecha de nacimiento
            SELECT TIMESTAMPDIFF(YEAR, c.birth_date, CURDATE())
            INTO edad
            FROM clients c
            WHERE c.id = NEW.client_id;
            -- Lógica de clasificación (la misma que antes)
            -- Casos para edad entre 15 y 19

        -- Actualizar el atributo VO2maxEvaluation en la tabla
            CASE
            WHEN edad BETWEEN 15 AND 19 THEN
                CASE
                    WHEN genero = 'Masculino' THEN
                        CASE
                            WHEN n > 56 THEN SET clasificacion = 'Superior';
                            WHEN n BETWEEN 52 AND 56 THEN SET clasificacion = 'Excelente';
                            WHEN n BETWEEN 47 AND 51 THEN SET clasificacion = 'Muy bien';
                            WHEN n BETWEEN 42 AND 46 THEN SET clasificacion = 'Bien';
                            WHEN n BETWEEN 37 AND 41 THEN SET clasificacion = 'Regular';
                            WHEN n BETWEEN 32 AND 36 THEN SET clasificacion = 'Pobre';
                            WHEN n < 32 THEN SET clasificacion = 'Muy pobre';
                            ELSE
                                SET clasificacion = 'else n';
                        END CASE;
                    WHEN genero = 'Femenino' THEN
                        CASE
                            WHEN n > 53 THEN SET clasificacion = 'Superior';
                            WHEN n BETWEEN 49 AND 53 THEN SET clasificacion = 'Excelente';
                            WHEN n BETWEEN 44 AND 48 THEN SET clasificacion = 'Muy bien';
                            WHEN n BETWEEN 39 AND 43 THEN SET clasificacion = 'Bien';
                            WHEN n BETWEEN 34 AND 38 THEN SET clasificacion = 'Regular';
                            WHEN n BETWEEN 29 AND 33 THEN SET clasificacion = 'Pobre';
                            WHEN n < 29 THEN SET clasificacion = 'Muy pobre';
                            ELSE
                                SET clasificacion = 'else n';
                        END CASE;
                    ELSE
                        SET clasificacion = genero;
                END CASE;
            ELSE
                SET clasificacion = 'else genero';
        END CASE;
            -- Actualizar el atributo VO2maxEvaluation en la tabla
            SET new.VO2maxEvaluation = clasificacion;

        end


         "
        );

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS after_insert_test_forestries");
        Schema::dropIfExists('test_forestries');
    }
};
