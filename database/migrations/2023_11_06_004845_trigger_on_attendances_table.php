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
    public function up()
    {
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
    public function down()
    {
        DB::unprepared("DROP TRIGGER IF EXISTS set_date_attendance_on_insert");
    }
};
