<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Tour;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ConfigTableSeeder::class,
            RolesAndPermissionsSeeder::class,
            CatCompanySeeder::class,
            CatPostsTableSeeder::class,
            CompanySeeder::class,
            UsersTableSeeder::class, 
            TourDateSeeder::class,
            BookingSeeder::class,            
            PostsTableSeeder::class,
        ]);
    }
}
