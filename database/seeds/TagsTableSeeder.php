<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('tags')->insert([
            ['name' => 'Real Estate', 'slug' => 'real-estate'],
            ['name' => 'Homes for Sale', 'slug' => 'homes-for-sale'],
            ['name' => 'Luxury Properties', 'slug' => 'luxury-properties'],
            ['name' => 'Commercial Real Estate', 'slug' => 'commercial-real-estate']
        ]);
    }
}
