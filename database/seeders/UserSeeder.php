<?php

namespace Database\Seeders;

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
        $userRole = Role::updateOrCreate(['name' => 'User']);

        $userRole->syncPermissions([
            'create comments',
            'delete comments'
        ]);
    }
}
