<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestimonialsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('testimonials')->insert([
            [
                'name'          => 'Jane Doe',
                'image'         => 'https://randomuser.me/api/portraits/women/1.jpg', // Online image link
                'testimonial'   => 'Contrary to popular belief, Lorem Ipsum is not simply random text.',
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'name'          => 'John Doe',
                'image'         => 'https://randomuser.me/api/portraits/men/1.jpg', // Online image link
                'testimonial'   => 'It has roots in a piece of classical Latin literature from 45 BC.',
                'created_at'    => now(),
                'updated_at'    => now(),
            ]
        ]);
    }
}
