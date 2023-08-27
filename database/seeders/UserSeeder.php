<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::class::create([
            'name' => 'SuperAdmin',
            'email' => 'nasuarezro@unal.edu.co',
            'email_verified_at' => now(),
            'password' => bcrypt('GymUnalCAPF'),
        ]);
        User::factory(99)->create();
    }
}
