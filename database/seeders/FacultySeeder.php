<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faculty;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faculty::class::create([
            'name' => 'Ciencias Exactas y Naturales',
        ]);
        Faculty::class::create([
            'name' => 'Administración',
        ]);
        Faculty::class::create([
            'name' => 'Ingeniería y arquitectura',
        ]);

        Faculty::class::create([
            'name' => 'Particular',
        ]);

    }
}
