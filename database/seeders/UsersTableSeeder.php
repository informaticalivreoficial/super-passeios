<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            [
                'email' => env('ADMIN_EMAIL'),
            ],

            [
                'name' => env('ADMIN_NOME'),
                'email_verified_at' => now(),
                'password' => bcrypt(
                    env('ADMIN_PASS')
                ),
                'remember_token' => Str::random(10),
                'status' => true,
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */
        if (!$user->hasRole('super-admin')) {
            $user->assignRole('super-admin');
        }
    }
}
