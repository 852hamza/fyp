<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('posts')->insert([
            [
                'title'        => 'Why Laravel is the Best PHP Framework',
                'slug'         => 'why-laravel-is-the-best',
                'body'         => 'Detailed post about why Laravel offers the best features...',
                'user_id'      => 1, // Assuming '1' is the ID of Admin
                'image'        => 'https://images.unsplash.com/photo-1517433456452-f9633a875f6f?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwzNjUyOXwwfDF8c2VhcmNofDF8fGFydGljbGV8ZW58MHx8fHwxNjg3NzI3MTY0&ixlib=rb-4.0.3&q=80&w=1080',
                'view_count'   => 150,
                'is_approved'  => true,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'title'        => 'Getting Started with React',
                'slug'         => 'getting-started-with-react',
                'body'         => 'An introduction to React and how to get started...',
                'user_id'      => 2, // Assuming '2' is the ID of Agent
                'image'        => 'https://images.unsplash.com/photo-1517433456452-f9633a875f6f?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwzNjUyOXwwfDF8c2VhcmNofDF8fGFydGljbGV8ZW58MHx8fHwxNjg3NzI3MTY0&ixlib=rb-4.0.3&q=80&w=1080',
                'view_count'   => 200,
                'is_approved'  => true,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'title'        => 'Mastering Node.js',
                'slug'         => 'mastering-nodejs',
                'body'         => 'Advanced techniques for developing applications with Node.js...',
                'user_id'      => 3, // Assuming '3' is the ID of User
                'image'        => 'https://images.unsplash.com/photo-1517433456452-f9633a875f6f?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=MnwzNjUyOXwwfDF8c2VhcmNofDF8fGFydGljbGV8ZW58MHx8fHwxNjg3NzI3MTY0&ixlib=rb-4.0.3&q=80&w=1080',
                'view_count'   => 300,
                'is_approved'  => true,
                'created_at'   => now(),
                'updated_at'   => now(),
            ]
        ]);
    }
}
