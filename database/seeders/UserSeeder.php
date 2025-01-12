<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@yopmail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password')
            ]
        );

        $adminRole = Role::findByName('Admin');
        $admin->syncRoles($adminRole);

        $user = User::firstOrCreate(
            ['email' => 'user@yopmail.com'],
            [
                'name' => 'User',
                'password' => bcrypt('password')
            ]
        );

        $userRole = Role::findByName('User');
        $user->syncRoles($userRole);
    }
}
