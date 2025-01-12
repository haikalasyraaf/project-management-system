<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::firstOrCreate(
            ['name' => 'Admin']
        );

        $user = Role::firstOrCreate(
            ['name' => 'User']
        );

        $permissions = Permission::pluck('id', 'id')->all();
        $admin->syncPermissions($permissions);

        $userPermissions = Permission::whereIn('name', [
            'view-project', 
            'view-expense', 
            'create-expense',
            'edit-expense',
            'delete-expense'
        ])->get();
        $user->syncPermissions($userPermissions);   
    }
}
