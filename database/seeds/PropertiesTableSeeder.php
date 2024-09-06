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
                'image'             => 'https://images.unsplash.com/photo-1484154218962-a197022b5858?q=80&w=2074&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
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
                'image'             => 'https://images.unsplash.com/photo-1502005229762-cf1b2da7c5d6?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
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
