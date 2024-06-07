<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostsTableSeeder extends Seeder
{
    public function run()
    {
        // Fetch all category IDs
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        // Insert a new post with a predefined image
        DB::table('posts')->insert([
            [
                'user_id'      => 1, // Assuming '1' is the ID of Admin
                'title'        => 'Top 10 Tips for Buying Your First Home',
                'slug'         => Str::slug('Top 10 Tips for Buying Your First Home'),
                'image'        => 'Residential.jpg', // Only the image filename
                'body'         => 'Buying your first home can be overwhelming. Here are the top 10 tips to help you navigate the process...',
                'view_count'   => 150,
                'status'       => true, // Set status to true for dummy data
                'is_approved'  => true,
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'user_id'      => 2, // Assuming '2' is the ID of Agent
                'title'        => 'How to Increase the Value of Your Property',
                'slug'         => Str::slug('How to Increase the Value of Your Property'),
                'image'        => 'Commercial.jpg', // Local image path
                'body'         => 'Increasing the value of your property doesn’t have to be complicated. Here are some effective strategies...',
                'view_count'   => 200,
                'status'       => true, // Set status to true for dummy data
                'is_approved'  => true,
                // 'category_id'  => $categoryIds[array_rand($categoryIds)], // Assign random category
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'user_id'      => 3, // Assuming '3' is the ID of User
                'title'        => 'The Ultimate Guide to Renting Out Your Property',
                'slug'         => Str::slug('The Ultimate Guide to Renting Out Your Property'),
                'image'        => 'Industrial.jpg', // Local image path
                'body'         => 'Renting out your property can be a great way to generate passive income. This guide will help you get started...',
                'view_count'   => 300,
                'status'       => true, // Set status to true for dummy data
                'is_approved'  => true,
                // 'category_id'  => $categoryIds[array_rand($categoryIds)], // Assign random category
                'created_at'   => now(),
                'updated_at'   => now(),
            ]
        ]);

        // Assuming you have pivot tables set up for post_tag and category_post relationships
        $post = DB::table('posts')->latest('id')->first();

        // Assign two random categories to the new post
        $selectedCategories = array_rand($categoryIds, 2); // Select two random categories
        foreach ($selectedCategories as $index) {
            DB::table('category_post')->insert([
                'post_id' => $post->id,
                'category_id' => $categoryIds[$index],
            ]);
        }

        // Assign 2 random tags to the new post
        $tagIds = DB::table('tags')->pluck('id')->toArray();
        $selectedTags = array_rand($tagIds, 2); // Select two random tags
        foreach ($selectedTags as $index) {
            DB::table('post_tag')->insert([
                'post_id' => $post->id,
                'tag_id' => $tagIds[$index],
            ]);
        }
    }
}
