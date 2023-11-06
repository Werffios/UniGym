<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\type_client;
class TypeClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //type_client::class::factory(1)->create();

        type_client::class::create([
            'name' => 'Estudiante',
            'fee' => 100000,
            'months' => 1,
        ]);
        type_client::class::create([
            'name' => 'Egresado',
            'fee' => 150000,
            'months' => 1,
        ]);
        type_client::class::create([
            'name' => 'Docente',
            'fee' => 200000,
            'months' => 1,
        ]);
        type_client::class::create([
            'name' => 'Administrativo',
            'fee' => 250000,
            'months' => 1,
        ]);
        type_client::class::create([
            'name' => 'Particular',
            'fee' => 300000,
            'months' => 1,
        ]);

    }
}
