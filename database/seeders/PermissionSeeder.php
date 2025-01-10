<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    protected $permissions = [
        'project' => [
            'view-project',
            'create-project',
            'edit-project',
            'delete-project'
        ],
        'expense' => [
            'view-expense',
            'create-expense',
            'edit-expense',
            'delete-expense',
            'review-expense',
        ],
        'invoice' => [
            'view-invoice',
            'create-invoice',
            'edit-invoice',
            'delete-invoice',
            'review-invoice',
        ],
        'user' => [
            'view-user',
            'create-user',
            'edit-user',
            'delete-user'
        ],
        'role' => [
            'view-role',
            'edit-role'
        ]
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guard_name = 'web';
        foreach($this->permissions as $module_name => $permissions) {
            foreach($permissions as $name) {
                $data = compact('name', 'guard_name', 'module_name');
                Permission::firstOrCreate($data);
            }
        }

        $adminPermissions = Permission::all();
        $admin = Role::where('name', 'Admin')->first();
        if($admin) {
            $admin->syncPermissions($adminPermissions);            
        }

        $userPermissions = Permission::whereIn('name', [
            'view-project', 
            'view-expense', 
            'create-expense',
            'edit-expense',
            'delete-expense'
        ])->get();

        $user = Role::where('name', 'User')->first();
        if($user) {
            $user->syncPermissions($userPermissions);            
        }
    }
}
