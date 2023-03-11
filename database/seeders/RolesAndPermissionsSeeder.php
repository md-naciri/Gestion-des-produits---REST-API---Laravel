<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'delete category']);
        Permission::create(['name' => 'store category']);
        Permission::create(['name' => 'update category']);

        Permission::create(['name' => 'delete my product']);
        Permission::create(['name' => 'delete every product']);
        Permission::create(['name' => 'store product']);
        Permission::create(['name' => 'update my product']);
        Permission::create(['name' => 'update every product']);

        Permission::create(['name' => 'assign role']);

        // this can be done as separate statements
        Role::create(['name' => 'admin'])->givePermissionTo(Permission::all());
        Role::create(['name' => 'vendor'])->givePermissionTo(
            'store product',
            'update my product',
            'delete my product'
        );

    }
}
