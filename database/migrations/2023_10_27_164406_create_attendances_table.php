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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->date('date_attendance');

            $table->unsignedBigInteger('client_id')->notNullValue();
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

            // Llave compuesta
            $table->unique(['client_id', 'date_attendance']);

            $table->timestamps();
        });

        // Crea el disparador

            $triggerSQL = "
            CREATE TRIGGER set_date_attendance_on_insert
            BEFORE INSERT ON attendances
            FOR EACH ROW
            BEGIN
                SET NEW.date_attendance = NOW();
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
        DB::unprepared("DROP TRIGGER IF EXISTS set_date_attendance_on_insert");

        Schema::dropIfExists('attendances');
    }
};
