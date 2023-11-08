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

        // Crea el disparador
        $triggerSQL = "
            CREATE TRIGGER set_start_and_end_date_on_insert
            BEFORE INSERT ON pays
            FOR EACH ROW
            BEGIN
                DECLARE monthsToAdd INT;
                DECLARE feeToAdd FLOAT;

                SELECT months, fee INTO monthsToAdd, feeToAdd FROM type_clients WHERE id = NEW.client_id;

                SET NEW.start_date = CURDATE();
                SET NEW.end_date = IF(monthsToAdd = 2, DATE_SUB(DATE_ADD(DATE_ADD(LAST_DAY(CURDATE()), INTERVAL 1 DAY), INTERVAL MOD(MONTH(CURDATE()), 2) MONTH), INTERVAL 1 DAY), DATE_ADD(NEW.start_date, INTERVAL monthsToAdd MONTH));
                SET NEW.amount = feeToAdd;
            END;
        ";

        DB::unprepared($triggerSQL);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Elimina el disparador
        DB::unprepared("DROP TRIGGER IF EXISTS set_start_and_end_date_on_insert");

        Schema::dropIfExists('pays');
    }
};
