<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin principal
        $user = User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL')],
            [
                'name'               => env('ADMIN_NOME'),
                'email_verified_at'  => now(),
                'password'           => bcrypt(env('ADMIN_PASS')),
                'remember_token'     => Str::random(10),
                'status'             => true,
            ]
        );

        if (!$user->hasRole('super-admin')) {
            $user->assignRole('super-admin');
        }

        // Admins
        User::factory(3)->create()->each(function ($user) {
            $user->assignRole('admin');
        });

        // Managers
        User::factory(5)->create()->each(function ($user) {
            $user->assignRole('manager');
        });
    }
}
