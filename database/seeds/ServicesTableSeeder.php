<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesTableSeeder extends Seeder
{
    public function run()
    {
        $services = [
            [
                'title' => 'Property Management',
                'description' => 'Comprehensive property management services to ensure your real estate operates smoothly, maximizing value and tenant satisfaction.',
                'icon' => 'account_balance_wallet', // Placeholder icon name
                'service_order' => 1
            ],
            [
                'title' => 'Real Estate Sales',
                'description' => 'Expert brokerage services to help you buy or sell properties with ease and confidence, leveraging deep market knowledge and a wide network.',
                'icon' => 'assignment_ind', // Placeholder icon name
                'service_order' => 2
            ],
            [
                'title' => 'Rental Services',
                'description' => 'End-to-end rental management, from marketing your properties to handling lease agreements and ensuring timely rent collection.',
                'icon' => 'home', // Placeholder icon name
                'service_order' => 3
            ]
        ];

        DB::table('services')->insert($services);
    }
}
