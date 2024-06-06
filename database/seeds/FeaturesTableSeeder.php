<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class FeaturesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('features')->insert([
            [
                'name'       => 'Swimming Pool',
                'slug'       => Str::slug('Swimming Pool'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Gym',
                'slug'       => Str::slug('Gym'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Garden',
                'slug'       => Str::slug('Garden'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
