<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Faker\Factory as Faker;

class SlidersTableSeeder extends Seeder
{
    public function run()
    {
        // Initialize Faker for generating dummy titles and descriptions
        $faker = Faker::create();

        // Define the path to the slider images
        $directory = storage_path('public/storage/category/slider');
        $files = File::files($directory);

        // Loop through each file found in the directory
        foreach ($files as $file) {
            DB::table('sliders')->insert([
                'title' => $faker->sentence(3),  // Generate a random title
                'description' => $faker->paragraph(3),  // Generate a random description
                'image' => $file->getFilename(),  // Store just the filename
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
