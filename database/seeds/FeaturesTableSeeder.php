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
            [
                'name'       => 'Parking Space',
                'slug'       => Str::slug('Parking Space'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Balcony',
                'slug'       => Str::slug('Balcony'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Fireplace',
                'slug'       => Str::slug('Fireplace'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'High Ceilings',
                'slug'       => Str::slug('High Ceilings'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Air Conditioning',
                'slug'       => Str::slug('Air Conditioning'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Hardwood Floors',
                'slug'       => Str::slug('Hardwood Floors'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Stainless Steel Appliances',
                'slug'       => Str::slug('Stainless Steel Appliances'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
