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
            UsersTableSeeder::class, 
            CatPostsTableSeeder::class,
            CompanySeeder::class,
            CustomerSeeder::class,
            BookingSeeder::class,
            PostsTableSeeder::class,
        ]);
    }
}
