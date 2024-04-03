<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $admin = User::updateOrCreate(
                [
                    'email' => 'admin@example.com',
                ],
                [
                    'first_name' => 'Admin',
                    'last_name' => 'Admin',
                    'password' => bcrypt('password'),
                ]
            );
            $adminRole = Role::updateOrCreate(['name' => 'Admin']);

            $admin->assignRole('Admin');
            $adminRole->syncPermissions(['create posts',
                'update posts',
                'delete posts',
                'create comments',
                'delete comments']);
        }
    }
}
