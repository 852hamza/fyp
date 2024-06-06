<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertiesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('properties')->insert([
            [
                'title'             => 'Modern Apartment',
                'slug'              => 'modern-apartment',
                'price'             => 300000,
                'featured'          => true,
                'purpose'           => 'sale',
                'type'              => 'apartment',
                'image'             => 'https://images.unsplash.com/photo-1599423300746-b62533397364?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwzNjUyOXwwfDF8c2VhcmNofDJ8fGx1eHVyeSUyMHZpbGxhfGVufDB8fHx8MTY4NzcyMjYwOQ&ixlib=rb-4.0.3&q=80&w=1080',
                'bedroom'           => 2,
                'bathroom'          => 1,
                'city'              => 'New York',
                'city_slug'         => 'new-york',
                'address'           => '123 Main St',
                'area'              => 1200,
                'agent_id'          => 1,
                'description'       => 'A beautiful apartment in the heart of the city.',
                'video'             => 'https://www.example.com/video1.mp4',
                'floor_plan'        => 'https://www.example.com/floorplan1.jpg',
                'location_latitude' => '40.7128',
                'location_longitude'=> '-74.0060',
                'nearby'            => 'Central Park',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'title'             => 'Cozy Cottage',
                'slug'              => 'cozy-cottage',
                'price'             => 200000,
                'featured'          => false,
                'purpose'           => 'rent',
                'type'              => 'house',
                'image'             => 'https://images.unsplash.com/photo-1600585154340-be6161dc29d9?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwzNjUyOXwwfDF8c2VhcmNofDF8fGNvdHRhZ2V8ZW58MHx8fHwxNjg3NzI2NTAx&ixlib=rb-4.0.3&q=80&w=1080',
                'bedroom'           => 3,
                'bathroom'          => 2,
                'city'              => 'San Francisco',
                'city_slug'         => 'san-francisco',
                'address'           => '456 Oak St',
                'area'              => 1400,
                'agent_id'          => 2,
                'description'       => 'A cozy cottage perfect for a small family.',
                'video'             => 'https://www.example.com/video2.mp4',
                'floor_plan'        => 'https://www.example.com/floorplan2.jpg',
                'location_latitude' => '37.7749',
                'location_longitude'=> '-122.4194',
                'nearby'            => 'Golden Gate Bridge',
                'created_at'        => now(),
                'updated_at'        => now(),
            ]
        ]);
    }
}
