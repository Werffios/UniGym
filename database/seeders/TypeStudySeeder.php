<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\type_study;

class TypeStudySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // type_study::class::factory(4)->create();
        type_study::class::create([
            'degree_id' => 1,
            'client_id' => 1,
        ]);
        type_study::class::create([
            'degree_id' => 2,
            'client_id' => 2,
        ]);
    }
}
