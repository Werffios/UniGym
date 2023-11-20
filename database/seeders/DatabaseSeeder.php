<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this -> call([
            TypeClientSeeder::class,
            TypeDocumentSeeder::class,
            TypeDegreeSeeder::class,
            FacultySeeder::class,
            DegreeSeeder::class,
            ClientSeeder::class,
            // AttendanceSeeder::class,

            UserSeeder::class,

            //PaySeeder::class,

            TestForceSeeder::class,
        ]);
    }
}
