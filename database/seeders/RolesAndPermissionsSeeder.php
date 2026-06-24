<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Permissions — guard web (users)
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
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        /*
        |--------------------------------------------------------------------------
        | Permissions — guard customer
        |--------------------------------------------------------------------------
        */
        $customerPermissions = [
            'view tours',
            'create bookings',
            'view bookings',
            'cancel bookings',

            // admin da company
            'view vessels',
            'create vessels',
            'edit vessels',
            'delete vessels',
            'create tours',
            'edit tours',
            'delete tours',
            'edit bookings',
        ];

        foreach ($customerPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'customer']);
        }

        /*
        |--------------------------------------------------------------------------
        | Roles — guard web
        |--------------------------------------------------------------------------
        */
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);
        $admin    = Role::firstOrCreate(['name' => 'admin',     'guard_name' => 'web']);
        $manager  = Role::firstOrCreate(['name' => 'manager',  'guard_name' => 'web']);

        /*
        |--------------------------------------------------------------------------
        | Roles — guard customer
        |--------------------------------------------------------------------------
        */
        $customerProprietary  = Role::firstOrCreate(['name' => 'proprietary',  'guard_name' => 'customer']);
        $customerClient = Role::firstOrCreate(['name' => 'client', 'guard_name' => 'customer']);

        /*
        |--------------------------------------------------------------------------
        | Assign Permissions
        |--------------------------------------------------------------------------
        */

        // web
        $superAdmin->givePermissionTo(Permission::where('guard_name', 'web')->get());

        $admin->givePermissionTo([
            'view vessels',
            'create vessels',
            'edit vessels',
            'view tours',
            'create tours',
            'edit tours',
            'view bookings',
            'edit bookings',
        ]);

        $manager->givePermissionTo([
            'view companies',
            'create companies',
            'edit companies',
            'view vessels',
            'create vessels',
            'edit vessels',
            'view tours',
            'create tours',
            'edit tours',
            'view bookings',
            'edit bookings',
        ]);

        // customer
        $customerProprietary->givePermissionTo(
            Permission::where('guard_name', 'customer')->get()
        );

        $customerClient->givePermissionTo([
            'view tours',
            'create bookings',
            'view bookings',
            'cancel bookings',
        ]);
    }
}
