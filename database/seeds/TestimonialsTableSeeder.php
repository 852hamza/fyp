<?php

// Uncomment if you're using namespaces
// namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Faker\Factory as Faker;
use Intervention\Image\Facades\Image;  // Make sure to import the Image facade

class TestimonialsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $directory = storage_path('app/public/testimonial');
        $files = File::files($directory);

        if (count($files) >= 3) {
            shuffle($files);
            $selectedFiles = array_slice($files, 0, 3);

            foreach ($selectedFiles as $file) {
                // Resize the image
                $img = Image::make($file->getPathname());
                $img->resize(160, 160)->save($file->getPathname());

                DB::table('testimonials')->insert([
                    'name' => $faker->name,
                    'image' => $file->getFilename(),
                    'testimonial' => substr($faker->realText(250), 0, 255),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        } else {
            echo "Not enough images available in the directory to create three testimonials.";
        }
    }
}
