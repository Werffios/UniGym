<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\degree;

class DegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        degree::class::create([
            'name' => 'Administración de sistemas informáticos',
            'type_degree_id' => 1,
        ]);
        degree::class::create([
            'name' => 'Administración de empresas',
            'type_degree_id' => 1,
        ]);
        degree::class::create([
            'name' => 'Gestión cultural',
            'type_degree_id' => 1,
        ]);
        degree::class::create([
            'name' => 'Ingeniería física',
            'type_degree_id' => 1,
        ]);
        degree::class::create([
            'name' => 'Ingeniería civil',
            'type_degree_id' => 1,
        ]);
        degree::class::create([
            'name' => 'Maeestría en administración de sistemas informáticos',
            'type_degree_id' => 2,
        ]);
        degree::class::create([
            'name' => 'Maeestría en administración de empresas',
            'type_degree_id' => 2,
        ]);
        degree::class::create([
            'name' => 'Maeestría en gestión cultural',
            'type_degree_id' => 2,
        ]);
    }
}
