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
                DECLARE feeToAdd FLOAT;

                SELECT fee INTO feeToAdd FROM type_clients WHERE id = NEW.client_id;

                SET NEW.start_date = NOW();
                SET NEW.amount = feeToAdd;
            END;

            CREATE TRIGGER after_delete_pays
            AFTER DELETE ON pays
            FOR EACH ROW
            BEGIN
                 DECLARE client_active INT;

                    -- Obtener el valor de active para el cliente que se está eliminando
                    SELECT active INTO client_active
                    FROM clients
                    WHERE id = OLD.client_id;

                    -- Actualizar el valor de active a 0 para el cliente en la tabla clients
                    UPDATE clients
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
