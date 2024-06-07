<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
             UsersTableSeeder::class,
             RolesTableSeeder::class,
             PropertiesTableSeeder::class,
             TestimonialsTableSeeder::class,
             CategoriesTableSeeder::class,
             FeaturesTableSeeder::class,
             TagsTableSeeder::class,
             SlidersTableSeeder::class,
             ServicesTableSeeder::class,
             PostsTableSeeder::class,
            // Add more seeders as needed
        ]);
    }
}
