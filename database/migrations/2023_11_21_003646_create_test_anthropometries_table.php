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

            // Subescapular
            $table->float('subscapular');

            // Suprailíaco
            $table->float('suprailiac');


            // Campos generados por triggers

                // Porcentaje de grasa
                $table->string('fatPercentage')->nullable();

                // Valoración de grasa
                $table->string('fatPercentageEvaluation')->nullable();

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
        DB::unprepared("

            CREATE TRIGGER test_anthropometries_trigger
            BEFORE INSERT ON `test_anthropometries`
            FOR EACH ROW
            BEGIN
                DECLARE client_height DOUBLE;
                DECLARE client_weight DOUBLE;
                DECLARE client_age INT;
                DECLARE client_gender VARCHAR(20);
                DECLARE client_sumOfSkinfolds DOUBLE;
                DECLARE addFatPercentage INT;

                SELECT gender INTO client_gender FROM clients WHERE id = NEW.client_id;
                SELECT TIMESTAMPDIFF(YEAR, c.birth_date, CURDATE()) INTO client_age FROM clients c WHERE c.id = NEW.client_id;
                SET client_sumOfSkinfolds = NEW.subscapular + NEW.suprailiac + NEW.tricepCircumference + NEW.bicepCircumference;
                SET NEW.date = NOW();

                SELECT height, weight INTO client_height, client_weight
                FROM clients
                WHERE clients.id = NEW.client_id;

                CASE
                    WHEN client_sumOfSkinfolds <= 14 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '6.7';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '9.4';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '9.3';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '12.7';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '9.5';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '15.6';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '9.7';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '17.0';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 14 AND client_sumOfSkinfolds <= 16 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '6.7';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '11.2';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '9.3';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '14.3';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '9.5';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '17.2';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '9.7';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '18.6';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 16 AND client_sumOfSkinfolds <= 18 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '7.9';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '12.7';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '10.8';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '15.7';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '10.9';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '18.5';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '11.0';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '20.1';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 18 AND client_sumOfSkinfolds <= 20 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '8.1';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '14.1';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '12.0';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '17.0';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '12.2';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '19.8';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '12.5';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '21.4';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 20 AND client_sumOfSkinfolds <= 22 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '9.2';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '15.4';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '13.0';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '18.1';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '13.5';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '20.9';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '13.9';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '22.6';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 22 AND client_sumOfSkinfolds <= 24 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '10.2';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '16.5';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '13.9';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '19.2';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '14.6';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '22.0';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '15.1';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '23.7';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 24 AND client_sumOfSkinfolds <= 26 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '11.2';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '17.6';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '14.7';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '20.1';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '15.7';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '22.9';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '16.3';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '24.8';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 26 AND client_sumOfSkinfolds <= 28 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '12.1';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '18.6';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '15.5';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '21.1';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '16.7';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '23.8';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '17.4';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '25.7';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 28 AND client_sumOfSkinfolds <= 30 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '12.9';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '19.5';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '16.2';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '21.9';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '17.6';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '24.6';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '18.5';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '26.6';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 30 AND client_sumOfSkinfolds <= 35 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '14.7';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '21.6';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '17.8';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '23.8';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '19.7';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '27.2';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '20.8';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '28.6';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 35 AND client_sumOfSkinfolds <= 40 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '16.3';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '23.4';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '19.2';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '25.5';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '21.5';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '28.1';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '22.8';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '30.3';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 40 AND client_sumOfSkinfolds <= 45 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '17.7';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '25.0';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '20.4';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '27.0';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '23.1';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '29.6';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '24.7';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '31.9';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 45 AND client_sumOfSkinfolds <= 50 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '19.0';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '26.5';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '21.5';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '28.3';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '24.6';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '30.9';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '26.3';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '33.2';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 50 AND client_sumOfSkinfolds <= 55 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '20.2';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '27.8';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '22.5';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '29.5';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '25.9';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '32.1';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '27.8';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '34.6';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 55 AND client_sumOfSkinfolds <= 60 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '21.2';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '29.1';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '23.5';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '30.6';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '27.1';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '33.2';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '29.1';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '35.7';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 60 AND client_sumOfSkinfolds <= 65 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '22.2';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '30.2';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '24.3';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '31.6';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '28.2';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '34.2';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '30.4';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '36.7';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 65 AND client_sumOfSkinfolds <= 70 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '23.2';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '31.2';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '25.1';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '32.6';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '29.3';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '35.1';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '31.5';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '37.7';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 70 AND client_sumOfSkinfolds <= 75 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '24.0';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '32.2';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '25.9';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '33.5';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '30.2';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '38.7';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '32.6';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '38.6';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 75 AND client_sumOfSkinfolds <= 80 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '24.8';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '33.1';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '26.6';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '34.3';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '31.2';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '36.8';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '33.7';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '39.5';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 80 AND client_sumOfSkinfolds <= 85 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '25.6';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '34.0';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '27.6';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '35.2';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '32.1';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '38.4';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '34.6';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '40.4';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 85 AND client_sumOfSkinfolds <= 90 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '26.3';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '34.8';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '28.3';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '36.0';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '32.9';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '39.1';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '35.5';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '41.1';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 90 AND client_sumOfSkinfolds <= 95 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '27.0';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '35.6';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '29.0';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '36.7';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '33.8';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '39.9';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '36.5';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '41.9';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 95 AND client_sumOfSkinfolds <= 100 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '27.6';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '36.3';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '29.7';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '38.4';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '34.5';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '40.6';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '37.3';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '42.6';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 100 AND client_sumOfSkinfolds <= 110 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '28.8';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '37.7';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '30.9';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '38.7';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '35.8';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '41.8';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '38.8';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '43.9';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 110 AND client_sumOfSkinfolds <= 120 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '29.9';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '39.0';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '32.0';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '39.9';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '37.1';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '43.0';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '40.2';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '45.1';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 120 AND client_sumOfSkinfolds <= 130 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '31.0';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '40.2';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '33.0';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '41.1';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '38.2';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '44.1';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '41.5';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '46.2';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 130 AND client_sumOfSkinfolds <= 140 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '31.9';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '41.3';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '34.0';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '42.1';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '39.4';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '45.1';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '42.8';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '47.3';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 140 AND client_sumOfSkinfolds <= 150 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '32.8';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '42.3';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '34.8';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '43.1';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '40.4';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '46.0';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '43.9';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '48.2';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 150 AND client_sumOfSkinfolds <= 160 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '33.6';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '43.2';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '35.7';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '44.0';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '41.4';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '46.9';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '45.0';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '49.1';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 160 AND client_sumOfSkinfolds <= 170 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '34.4';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '44.6';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '36.5';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '45.1';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '42.3';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '47.8';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '46.0';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '50.0';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 170 AND client_sumOfSkinfolds <= 180 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '35.2';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '45.0';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '37.2';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '45.6';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '43.1';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '48.5';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '47.0';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '50.8';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 180 AND client_sumOfSkinfolds <= 190 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '35.9';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '45.8';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '37.9';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '46.4';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '43.9';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '49.3';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '47.9';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '51.6';
                                END CASE;
                        END CASE;
                    WHEN client_sumOfSkinfolds > 190 AND client_sumOfSkinfolds <= 200 THEN
                        CASE
                            WHEN client_age <= 29 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '36.5';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '46.6';
                                END CASE;
                            WHEN client_age > 29 AND client_age <= 39 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '38.6';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '47.1';
                                END CASE;
                            WHEN client_age > 39 AND client_age <= 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '44.7';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '50.0';
                                END CASE;
                            WHEN client_age > 49 THEN
                                CASE
                                    WHEN client_gender = 'Masculino' THEN
                                        SET NEW.fatPercentage = '48.8';
                                    WHEN client_gender = 'Femenino' THEN
                                        SET NEW.fatPercentage = '52.3';
                                END CASE;
                        END CASE;
                END CASE;

                SET NEW.IMC = Round((client_weight / (client_height/100 * client_height/100)), 2);

                IF NEW.IMC < 18.5 THEN
                    SET NEW.IMCEvaluation = 'Peso insuficiente';
                ELSEIF NEW.IMC >= 18.5 AND NEW.IMC <= 24.9 THEN
                    SET NEW.IMCEvaluation = 'Peso normal';
                ELSEIF NEW.IMC >= 25 AND NEW.IMC <= 26.9 THEN
                    SET NEW.IMCEvaluation = 'Sobrepeso grado I';
                ELSEIF NEW.IMC >= 27 AND NEW.IMC <= 29.9 THEN
                    SET NEW.IMCEvaluation = 'Sobrepeso grado II (pre-obesidad)';
                ELSEIF NEW.IMC >= 30 AND NEW.IMC <= 34.9 THEN
                    SET NEW.IMCEvaluation = 'Obesidad de tipo I';
                ELSEIF NEW.IMC >= 35 AND NEW.IMC <= 39.9 THEN
                    SET NEW.IMCEvaluation = 'Obesidad de tipo II';
                ELSEIF NEW.IMC >= 40 AND NEW.IMC <= 49.9 THEN
                    SET NEW.IMCEvaluation = 'Obesidad de tipo III (mórbida)';
                ELSEIF NEW.IMC >= 50 THEN
                    SET NEW.IMCEvaluation = 'Obesidad de tipo IV (extrema)';
                END IF;

                SET NEW.healthyWeight = Round((client_height/100 * client_height/100) * 22.5, 2);

                SET addFatPercentage = 0;
                CASE
                    WHEN client_age >= 20 AND client_age < 30 THEN
                        CASE
                            WHEN client_gender = 'Masculino' THEN
                                SET addFatPercentage = 1;
                            WHEN client_gender = 'Femenino' THEN
                                SET addFatPercentage = 6;
                        END CASE;
                    WHEN client_age >= 30 AND client_age < 40 THEN
                        CASE
                            WHEN client_gender = 'Masculino' THEN
                                SET addFatPercentage = 2;
                            WHEN client_gender = 'Femenino' THEN
                                SET addFatPercentage = 7;
                        END CASE;
                    WHEN client_age >= 40 AND client_age < 50 THEN
                        CASE
                            WHEN client_gender = 'Masculino' THEN
                                SET addFatPercentage = 3;
                            WHEN client_gender = 'Femenino' THEN
                                SET addFatPercentage = 8;
                        END CASE;
                    WHEN client_age >= 50 THEN
                        CASE
                            WHEN client_gender = 'Masculino' THEN
                                SET addFatPercentage = 4;
                            WHEN client_gender = 'Femenino' THEN
                                SET addFatPercentage = 9;
                        END CASE;
                END CASE;

                CASE
                    WHEN NEW.fatPercentage < 12.5 + addFatPercentage THEN
                        SET NEW.fatPercentageEvaluation = 'BAJO';
                    WHEN NEW.fatPercentage >= 12.5 + addFatPercentage AND NEW.fatPercentage < 17.5 + addFatPercentage THEN
                        SET NEW.fatPercentageEvaluation = 'BIEN';
                    WHEN NEW.fatPercentage >= 17.5 + addFatPercentage AND NEW.fatPercentage < 22.5 + addFatPercentage THEN
                        SET NEW.fatPercentageEvaluation = 'MODERADO';
                    WHEN NEW.fatPercentage >= 22.5 + addFatPercentage AND NEW.fatPercentage < 27.5 + addFatPercentage THEN
                        SET NEW.fatPercentageEvaluation = 'ALTO';
                    WHEN NEW.fatPercentage >= 27.5 + addFatPercentage THEN
                        SET NEW.fatPercentageEvaluation = 'OBESO';
                END CASE;

            END

            "
            );

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   // Elimina el disparador
        DB::unprepared("DROP TRIGGER IF EXISTS test_anthropometries_trigger");
        Schema::dropIfExists('test_anthropometries');

    }
};
