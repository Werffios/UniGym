<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\type_degree;

class TypeDegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // type_degree::class::factory(4)->create();
        type_degree::class::create([
            'name' => 'Pregrado',
        ]);
        type_degree::class::create([
            'name' => 'Especialización',
        ]);
        type_degree::class::create([
            'name' => 'Maestría',
        ]);
        type_degree::class::create([
            'name' => 'Doctorado',
        ]);
        type_degree::class::create([
            'name' => 'Particular',
        ]);
    }
}
