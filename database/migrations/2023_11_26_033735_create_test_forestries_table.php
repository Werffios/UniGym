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

        CREATE TRIGGER test_forestries_trigger
        BEFORE INSERT ON test_forestries
        FOR EACH ROW
        BEGIN
            -- Variables de entrada desde la tabla insertada
            DECLARE edad INT;
            DECLARE genero VARCHAR(255);
            DECLARE VO2 DECIMAL(10,2);
            DECLARE n INT;
            -- Variables para la clasificación
            DECLARE clasificacion VARCHAR(255);

            -- hallar genero y guardar en la columna
            SELECT gender INTO genero FROM clients WHERE id = NEW.client_id;

            -- declarar fecha
            SET NEW.date = NOW();

            -- calcular VO2max
            CASE
                WHEN genero = 'Masculino' THEN SET VO2 = 111.33 - 0.42 * New.effortPulse;
                WHEN genero = 'Femenino' THEN SET VO2 = 65.81 - 0.1847 * New.effortPulse;
            END CASE;
            -- Actualizar el atributo VO2max en la tabla
            SET New.VO2max = CAST(VO2 AS UNSIGNED);
            -- Obtener VO2max insertado a  n
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
                                SET clasificacion = 'No se pudo calcular';
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
                            --  de vo2 aajus
                            ELSE
                                SET clasificacion = 'No se pudo calcular';
                        END CASE;
                        -- else de genero
                    ELSE
                        SET clasificacion = genero;
                END CASE;
            -- 2 caso de edades
            WHEN edad BETWEEN 20 AND 24 THEN
                CASE
                    WHEN genero = 'Masculino' THEN
                        CASE
                            WHEN n > 55 THEN SET clasificacion = 'Superior';
                            WHEN n BETWEEN 51 AND 55 THEN SET clasificacion = 'Excelente';
                            WHEN n BETWEEN 46 AND 50 THEN SET clasificacion = 'Muy bien';
                            WHEN n BETWEEN 41 AND 45 THEN SET clasificacion = 'Bien';
                            WHEN n BETWEEN 36 AND 40 THEN SET clasificacion = 'Regular';
                            WHEN n BETWEEN 31 AND 35 THEN SET clasificacion = 'Pobre';
                            WHEN n < 31 THEN SET clasificacion = 'Muy pobre';
                            ELSE
                                SET clasificacion = 'No se pudo calcular';
                        END CASE;
                    WHEN genero = 'Femenino' THEN
                        CASE
                            WHEN n > 52 THEN SET clasificacion = 'Superior';
                            WHEN n BETWEEN 49 AND 52 THEN SET clasificacion = 'Excelente';
                            WHEN n BETWEEN 43 AND 47 THEN SET clasificacion = 'Muy bien';
                            WHEN n BETWEEN 36 AND 42 THEN SET clasificacion = 'Bien';
                            WHEN n BETWEEN 33 AND 37 THEN SET clasificacion = 'Regular';
                            WHEN n BETWEEN 28 AND 32 THEN SET clasificacion = 'Pobre';
                            WHEN n < 28 THEN SET clasificacion = 'Muy pobre';
                            --  de vo2 aajus
                            ELSE
                                SET clasificacion = 'No se pudo calcular';
                        END CASE;
                        -- else de genero
                    ELSE
                        SET clasificacion = genero;
                END CASE;
                -- 3 caso de edades
            WHEN edad BETWEEN 25 AND 29 THEN
                CASE
                    WHEN genero = 'Masculino' THEN
                        CASE
                            WHEN n > 54 THEN SET clasificacion = 'Superior';
                            WHEN n BETWEEN 50 AND 54 THEN SET clasificacion = 'Excelente';
                            WHEN n BETWEEN 45 AND 49 THEN SET clasificacion = 'Muy bien';
                            WHEN n BETWEEN 40 AND 44 THEN SET clasificacion = 'Bien';
                            WHEN n BETWEEN 35 AND 39 THEN SET clasificacion = 'Regular';
                            WHEN n BETWEEN 30 AND 34 THEN SET clasificacion = 'Pobre';
                            WHEN n < 30 THEN SET clasificacion = 'Muy pobre';
                            ELSE
                                SET clasificacion = 'No se pudo calcular';
                        END CASE;
                    WHEN genero = 'Femenino' THEN
                        CASE
                            WHEN n > 51 THEN SET clasificacion = 'Superior';
                            WHEN n BETWEEN 47 AND 51 THEN SET clasificacion = 'Excelente';
                            WHEN n BETWEEN 42 AND 46 THEN SET clasificacion = 'Muy bien';
                            WHEN n BETWEEN 37 AND 41 THEN SET clasificacion = 'Bien';
                            WHEN n BETWEEN 32 AND 36 THEN SET clasificacion = 'Regular';
                            WHEN n BETWEEN 27 AND 31 THEN SET clasificacion = 'Pobre';
                            WHEN n < 27 THEN SET clasificacion = 'Muy pobre';
                            --  de vo2 aajus
                            ELSE
                                SET clasificacion = 'No se pudo calcular';
                        END CASE;
                        -- else de genero
                    ELSE
                        SET clasificacion = genero;
                END CASE;
                -- 4 caso de edades
            WHEN edad BETWEEN 30 AND 34 THEN
                CASE
                    WHEN genero = 'Masculino' THEN
                        CASE
                            WHEN n > 53 THEN SET clasificacion = 'Superior';
                            WHEN n BETWEEN 49 AND 53 THEN SET clasificacion = 'Excelente';
                            WHEN n BETWEEN 44 AND 48 THEN SET clasificacion = 'Muy bien';
                            WHEN n BETWEEN 39 AND 43 THEN SET clasificacion = 'Bien';
                            WHEN n BETWEEN 34 AND 38 THEN SET clasificacion = 'Regular';
                            WHEN n BETWEEN 29 AND 33 THEN SET clasificacion = 'Pobre';
                            WHEN n < 29 THEN SET clasificacion = 'Muy pobre';
                            ELSE
                                SET clasificacion = 'No se pudo calcular';
                        END CASE;
                    WHEN genero = 'Femenino' THEN
                        CASE
                            WHEN n > 50 THEN SET clasificacion = 'Superior';
                            WHEN n BETWEEN 46 AND 50 THEN SET clasificacion = 'Excelente';
                            WHEN n BETWEEN 41 AND 45 THEN SET clasificacion = 'Muy bien';
                            WHEN n BETWEEN 36 AND 40 THEN SET clasificacion = 'Bien';
                            WHEN n BETWEEN 31 AND 35 THEN SET clasificacion = 'Regular';
                            WHEN n BETWEEN 26 AND 30 THEN SET clasificacion = 'Pobre';
                            WHEN n < 26 THEN SET clasificacion = 'Muy pobre';
                            --  de vo2 aajus
                            ELSE
                                SET clasificacion = 'No se pudo calcular';
                        END CASE;
                        -- else de genero
                    ELSE
                        SET clasificacion = genero;
                END CASE;
                -- 5 caso de edades
            WHEN edad BETWEEN 35 AND 39 THEN
                CASE
                    WHEN genero = 'Masculino' THEN
                        CASE
                            WHEN n > 52 THEN SET clasificacion = 'Superior';
                            WHEN n BETWEEN 48 AND 52 THEN SET clasificacion = 'Excelente';
                            WHEN n BETWEEN 43 AND 47 THEN SET clasificacion = 'Muy bien';
                            WHEN n BETWEEN 38 AND 42 THEN SET clasificacion = 'Bien';
                            WHEN n BETWEEN 33 AND 37 THEN SET clasificacion = 'Regular';
                            WHEN n BETWEEN 28 AND 32 THEN SET clasificacion = 'Pobre';
                            WHEN n < 28 THEN SET clasificacion = 'Muy pobre';
                            ELSE
                                SET clasificacion = 'No se pudo calcular';
                        END CASE;
                    WHEN genero = 'Femenino' THEN
                        CASE
                            WHEN n > 49 THEN SET clasificacion = 'Superior';
                            WHEN n BETWEEN 45 AND 49 THEN SET clasificacion = 'Excelente';
                            WHEN n BETWEEN 40 AND 44 THEN SET clasificacion = 'Muy bien';
                            WHEN n BETWEEN 35 AND 39 THEN SET clasificacion = 'Bien';
                            WHEN n BETWEEN 30 AND 34 THEN SET clasificacion = 'Regular';
                            WHEN n BETWEEN 25 AND 29 THEN SET clasificacion = 'Pobre';
                            WHEN n < 25 THEN SET clasificacion = 'Muy pobre';
                            --  de vo2 aajus
                            ELSE
                                SET clasificacion = 'No se pudo calcular';
                        END CASE;
                        -- else de genero
                    ELSE
                        SET clasificacion = genero;
                END CASE;
                -- 6 caso de edades
            WHEN edad BETWEEN 40 AND 44 THEN
                CASE
                    WHEN genero = 'Masculino' THEN
                        CASE
                            WHEN n > 51 THEN SET clasificacion = 'Superior';
                            WHEN n BETWEEN 47 AND 51 THEN SET clasificacion = 'Excelente';
                            WHEN n BETWEEN 42 AND 46 THEN SET clasificacion = 'Muy bien';
                            WHEN n BETWEEN 37 AND 41 THEN SET clasificacion = 'Bien';
                            WHEN n BETWEEN 32 AND 36 THEN SET clasificacion = 'Regular';
                            WHEN n BETWEEN 27 AND 31 THEN SET clasificacion = 'Pobre';
                            WHEN n < 27 THEN SET clasificacion = 'Muy pobre';
                            ELSE
                                SET clasificacion = 'No se pudo calcular';
                        END CASE;
                    WHEN genero = 'Femenino' THEN
                        CASE
                            WHEN n > 48 THEN SET clasificacion = 'Superior';
                            WHEN n BETWEEN 44 AND 48 THEN SET clasificacion = 'Excelente';
                            WHEN n BETWEEN 39 AND 43 THEN SET clasificacion = 'Muy bien';
                            WHEN n BETWEEN 34 AND 38 THEN SET clasificacion = 'Bien';
                            WHEN n BETWEEN 29 AND 33 THEN SET clasificacion = 'Regular';
                            WHEN n BETWEEN 24 AND 28 THEN SET clasificacion = 'Pobre';
                            WHEN n < 24 THEN SET clasificacion = 'Muy pobre';
                            --  de vo2 aajus
                            ELSE
                                SET clasificacion = 'No se pudo calcular';
                        END CASE;
                        -- else de genero
                    ELSE
                        SET clasificacion = genero;
                END CASE;
                -- 7 caso de edades
            WHEN edad BETWEEN 45 AND 49 THEN
                CASE
                    WHEN genero = 'Masculino' THEN
                        CASE
                            WHEN n > 50 THEN SET clasificacion = 'Superior';
                            WHEN n BETWEEN 46 AND 50 THEN SET clasificacion = 'Excelente';
                            WHEN n BETWEEN 41 AND 45 THEN SET clasificacion = 'Muy bien';
                            WHEN n BETWEEN 36 AND 40 THEN SET clasificacion = 'Bien';
                            WHEN n BETWEEN 31 AND 35 THEN SET clasificacion = 'Regular';
                            WHEN n BETWEEN 26 AND 30 THEN SET clasificacion = 'Pobre';
                            WHEN n < 26 THEN SET clasificacion = 'Muy pobre';
                            ELSE
                                SET clasificacion = 'No se pudo calcular';
                        END CASE;
                    WHEN genero = 'Femenino' THEN
                        CASE
                            WHEN n > 47 THEN SET clasificacion = 'Superior';
                            WHEN n BETWEEN 43 AND 47 THEN SET clasificacion = 'Excelente';
                            WHEN n BETWEEN 38 AND 42 THEN SET clasificacion = 'Muy bien';
                            WHEN n BETWEEN 33 AND 37 THEN SET clasificacion = 'Bien';
                            WHEN n BETWEEN 28 AND 32 THEN SET clasificacion = 'Regular';
                            WHEN n BETWEEN 23 AND 27 THEN SET clasificacion = 'Pobre';
                            WHEN n < 23 THEN SET clasificacion = 'Muy pobre';
                            --  de vo2 aajus
                            ELSE
                                SET clasificacion = 'No se pudo calcular';
                        END CASE;
                        -- else de genero
                    ELSE
                        SET clasificacion = genero;
                END CASE;
                -- 8 caso de edades
            WHEN edad BETWEEN 50 AND 54 THEN
                CASE
                    WHEN genero = 'Masculino' THEN
                        CASE
                            WHEN n > 49 THEN SET clasificacion = 'Superior';
                            WHEN n BETWEEN 45 AND 49 THEN SET clasificacion = 'Excelente';
                            WHEN n BETWEEN 40 AND 44 THEN SET clasificacion = 'Muy bien';
                            WHEN n BETWEEN 35 AND 39 THEN SET clasificacion = 'Bien';
                            WHEN n BETWEEN 30 AND 34 THEN SET clasificacion = 'Regular';
                            WHEN n BETWEEN 25 AND 29 THEN SET clasificacion = 'Pobre';
                            WHEN n < 25 THEN SET clasificacion = 'Muy pobre';
                            ELSE
                                SET clasificacion = 'No se pudo calcular';
                        END CASE;
                    WHEN genero = 'Femenino' THEN
                        CASE
                            WHEN n > 46 THEN SET clasificacion = 'Superior';
                            WHEN n BETWEEN 42 AND 46 THEN SET clasificacion = 'Excelente';
                            WHEN n BETWEEN 37 AND 41 THEN SET clasificacion = 'Muy bien';
                            WHEN n BETWEEN 32 AND 36 THEN SET clasificacion = 'Bien';
                            WHEN n BETWEEN 27 AND 31 THEN SET clasificacion = 'Regular';
                            WHEN n BETWEEN 22 AND 26 THEN SET clasificacion = 'Pobre';
                            WHEN n < 22 THEN SET clasificacion = 'Muy pobre';
                            --  de vo2 aajus
                            ELSE
                                SET clasificacion = 'No se pudo calcular';
                        END CASE;
                        -- else de genero
                    ELSE
                        SET clasificacion = genero;
                END CASE;
                -- 9 caso de edades
            WHEN edad BETWEEN 55 AND 59 THEN
                CASE
                    WHEN genero = 'Masculino' THEN
                        CASE
                            WHEN n > 48 THEN SET clasificacion = 'Superior';
                            WHEN n BETWEEN 44 AND 48 THEN SET clasificacion = 'Excelente';
                            WHEN n BETWEEN 39 AND 43 THEN SET clasificacion = 'Muy bien';
                            WHEN n BETWEEN 34 AND 38 THEN SET clasificacion = 'Bien';
                            WHEN n BETWEEN 29 AND 33 THEN SET clasificacion = 'Regular';
                            WHEN n BETWEEN 24 AND 28 THEN SET clasificacion = 'Pobre';
                            WHEN n < 24 THEN SET clasificacion = 'Muy pobre';
                            ELSE
                                SET clasificacion = 'No se pudo calcular';
                        END CASE;
                    WHEN genero = 'Femenino' THEN
                        CASE
                            WHEN n > 45 THEN SET clasificacion = 'Superior';
                            WHEN n BETWEEN 41 AND 45 THEN SET clasificacion = 'Excelente';
                            WHEN n BETWEEN 36 AND 40 THEN SET clasificacion = 'Muy bien';
                            WHEN n BETWEEN 31 AND 35 THEN SET clasificacion = 'Bien';
                            WHEN n BETWEEN 26 AND 30 THEN SET clasificacion = 'Regular';
                            WHEN n BETWEEN 21 AND 25 THEN SET clasificacion = 'Pobre';
                            WHEN n < 21 THEN SET clasificacion = 'Muy pobre';
                            --  de vo2 aajus
                            ELSE
                                SET clasificacion = 'No se pudo calcular';
                        END CASE;
                        -- else de genero
                    ELSE
                        SET clasificacion = genero;
                END CASE;
                -- 10 caso de edades
            WHEN edad BETWEEN 60 AND 64 THEN
                CASE
                    WHEN genero = 'Masculino' THEN
                        CASE
                            WHEN n > 47 THEN SET clasificacion = 'Superior';
                            WHEN n BETWEEN 43 AND 47 THEN SET clasificacion = 'Excelente';
                            WHEN n BETWEEN 38 AND 42 THEN SET clasificacion = 'Muy bien';
                            WHEN n BETWEEN 33 AND 37 THEN SET clasificacion = 'Bien';
                            WHEN n BETWEEN 28 AND 32 THEN SET clasificacion = 'Regular';
                            WHEN n BETWEEN 23 AND 27 THEN SET clasificacion = 'Pobre';
                            WHEN n < 23 THEN SET clasificacion = 'Muy pobre';
                            ELSE
                                SET clasificacion = 'No se pudo calcular';
                        END CASE;
                    WHEN genero = 'Femenino' THEN
                        CASE
                            WHEN n > 44 THEN SET clasificacion = 'Superior';
                            WHEN n BETWEEN 40 AND 44 THEN SET clasificacion = 'Excelente';
                            WHEN n BETWEEN 35 AND 39 THEN SET clasificacion = 'Muy bien';
                            WHEN n BETWEEN 30 AND 34 THEN SET clasificacion = 'Bien';
                            WHEN n BETWEEN 25 AND 29 THEN SET clasificacion = 'Regular';
                            WHEN n BETWEEN 20 AND 24 THEN SET clasificacion = 'Pobre';
                            WHEN n < 20 THEN SET clasificacion = 'Muy pobre';
                            --  de vo2 aajus
                            ELSE
                                SET clasificacion = 'No se pudo calcular';
                        END CASE;
                        -- else de genero
                    ELSE
                        SET clasificacion = genero;
                END CASE;
                -- 11 caso de edades
            WHEN edad > 64 THEN
                CASE
                    WHEN genero = 'Masculino' THEN
                        CASE
                            WHEN n > 46 THEN SET clasificacion = 'Superior';
                            WHEN n BETWEEN 42 AND 46 THEN SET clasificacion = 'Excelente';
                            WHEN n BETWEEN 37 AND 41 THEN SET clasificacion = 'Muy bien';
                            WHEN n BETWEEN 32 AND 36 THEN SET clasificacion = 'Bien';
                            WHEN n BETWEEN 27 AND 31 THEN SET clasificacion = 'Regular';
                            WHEN n BETWEEN 22 AND 26 THEN SET clasificacion = 'Pobre';
                            WHEN n < 22 THEN SET clasificacion = 'Muy pobre';
                            ELSE
                                SET clasificacion = 'No se pudo calcular';
                        END CASE;
                    WHEN genero = 'Femenino' THEN
                        CASE
                            WHEN n > 43 THEN SET clasificacion = 'Superior';
                            WHEN n BETWEEN 39 AND 43 THEN SET clasificacion = 'Excelente';
                            WHEN n BETWEEN 34 AND 38 THEN SET clasificacion = 'Muy bien';
                            WHEN n BETWEEN 29 AND 33 THEN SET clasificacion = 'Bien';
                            WHEN n BETWEEN 24 AND 28 THEN SET clasificacion = 'Regular';
                            WHEN n BETWEEN 20 AND 23 THEN SET clasificacion = 'Pobre';
                            WHEN n < 20 THEN SET clasificacion = 'Muy pobre';
                            --  de vo2 aajus
                            ELSE
                                SET clasificacion = 'No se pudo calcular';
                        END CASE;
                        -- else de genero
                    ELSE
                        SET clasificacion = genero;
                END CASE;
                -- else de todo, es decir de las edades
            ELSE
                SET clasificacion = 'else genero';
        END CASE;
            -- Actualizar el atributo VO2maxEvaluation en la tabla
            SET new.VO2maxEvaluation = clasificacion;

            -- Calcular FCmax
            SET new.FCmax = 220 - edad;

            -- Calcular FCReposo
            SET new.FCReposo = New.restingPulse;

            -- Calcular FCReserva
            SET new.FCReserva = New.FCmax - New.FCReposo;

        end


         "
        );

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS test_forestries_trigger");
        Schema::dropIfExists('test_forestries');
    }
};
