<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $directory = storage_path('app/public/category/slider');

        // Category names and slugs
        $categories = [
            ['name' => 'Residential', 'slug' => Str::slug('Residential')],
            ['name' => 'Commercial', 'slug' => Str::slug('Commercial')],
            ['name' => 'Industrial', 'slug' => Str::slug('Industrial')],
        ];

        foreach ($categories as $category) {
            $imagePath = $directory . '/' . $category['name'] . '.jpg';

            // Check if the image exists
            if (File::exists($imagePath)) {
                $image = $category['name'] . '.jpg';
            } else {
                // Fallback to default image if the specific image is not found
                $image = 'default.png';
            }

            DB::table('categories')->insert([
                'name'       => $category['name'],
                'slug'       => $category['slug'],
                'image'      => $image,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
