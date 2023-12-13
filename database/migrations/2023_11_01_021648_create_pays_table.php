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
        Schema::create('pays', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->float('amount')->nullable();

            // Añade las columnas de llave foránea
            $table->unsignedBigInteger('client_id');

            // Crea las restricciones de llave foránea
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

            $table->timestamps();
        });

        DB::unprepared(
            '
            CREATE TRIGGER pays_trigger
            BEFORE INSERT ON pays
            FOR EACH ROW
                BEGIN
            DECLARE monthsToAdd INT;
                DECLARE feeToAdd FLOAT;

                SELECT months, fee INTO monthsToAdd, feeToAdd FROM type_clients WHERE id = NEW.client_id;

                SET NEW.start_date = NOW();
                SET NEW.end_date = IF(monthsToAdd = 2, DATE_SUB(DATE_ADD(DATE_ADD(LAST_DAY(CURDATE()), INTERVAL 1 DAY), INTERVAL MOD(MONTH(CURDATE()), 2) MONTH), INTERVAL 1 DAY), DATE_ADD(NEW.start_date, INTERVAL monthsToAdd MONTH));
                SET NEW.amount = feeToAdd;
            END;

            CREATE TRIGGER after_delete_pays
            AFTER DELETE ON unigym.pays
            FOR EACH ROW
            BEGIN
                DECLARE client_active INT;

                -- Obtener el valor de active para el cliente que se está eliminando
                SELECT active INTO client_active
                FROM unigym.clients
                WHERE id = OLD.client_id;

                -- Actualizar el valor de active a 0 para el cliente en la tabla clients
                UPDATE unigym.clients
                SET active = 0
                WHERE id = OLD.client_id;
            END;

            '
        );

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Elimina el disparador
        DB::unprepared("DROP TRIGGER IF EXISTS pays_trigger");

        Schema::dropIfExists('pays');
    }
};
