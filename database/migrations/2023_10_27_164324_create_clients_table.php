<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('document')->unique();
            $table->string('name');
            $table->string('surname');
            $table->integer('height');
            $table->integer('weight');
            $table->enum('gender', ['Masculino', 'Femenino']);
            $table->date('birth_date');
            $table->boolean('active')->default(true);

            // Añade las columnas de llave foránea
            $table->unsignedBigInteger('type_client_id');
            $table->unsignedBigInteger('type_document_id');
            $table->unsignedBigInteger('type_degree_id');

            // Crea las restricciones de llave foránea
            $table->foreign('type_client_id')->references('id')->on('type_clients')->onDelete('cascade');
            $table->foreign('type_document_id')->references('id')->on('type_documents')->onDelete('cascade');
            $table->foreign('type_degree_id')->references('id')->on('type_degrees')->onDelete('restrict');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
