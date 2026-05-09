<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Permissions
        |--------------------------------------------------------------------------
        */

        $permissions = [

            // Companies
            'view companies',
            'create companies',
            'edit companies',
            'delete companies',

            // Vessels
            'view vessels',
            'create vessels',
            'edit vessels',
            'delete vessels',

            // Tours
            'view tours',
            'create tours',
            'edit tours',
            'delete tours',

            // Bookings
            'view bookings',
            'create bookings',
            'edit bookings',
            'cancel bookings',

        ];

        foreach ($permissions as $permission) {

            Permission::firstOrCreate([
                'name' => $permission
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Roles
        |--------------------------------------------------------------------------
        */

        $superAdmin = Role::firstOrCreate([
            'name' => 'super-admin'
        ]);

        $company = Role::firstOrCreate([
            'name' => 'company'
        ]);

        $customer = Role::firstOrCreate([
            'name' => 'customer'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Assign Permissions
        |--------------------------------------------------------------------------
        */

        $superAdmin->givePermissionTo(Permission::all());

        $company->givePermissionTo([
            'view vessels',
            'create vessels',
            'edit vessels',

            'view tours',
            'create tours',
            'edit tours',

            'view bookings',
            'edit bookings',
        ]);
    }
}
