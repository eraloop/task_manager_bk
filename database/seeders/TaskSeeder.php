<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TaskSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Create 10 dummy tasks
        for ($i = 0; $i < 10; $i++) {
            DB::table('tasks')->insert([
                'title' => $faker->sentence(5),
                'description' => $faker->paragraph(3),
                'status' => $faker->randomElement(['pending', 'completed']), 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
