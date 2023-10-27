<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\type_document;

class TypeDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // type_document::class::factory(4)->create();

        type_document::class::create([
            'name' => 'Cédula de ciudadanía',
        ]);
        type_document::class::create([
            'name' => 'Cédula de extranjería',
        ]);
        type_document::class::create([
            'name' => 'Tarjeta de identidad',
        ]);
    }
}
