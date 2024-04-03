<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
        public function run(): void
    {
        $permission_names = [
            'create posts',
            'update posts',
            'delete posts',
            'create comments',
            'delete comments'
        ];

        foreach ($permission_names as $permission_name) {
            Permission::firstOrCreate(['name' => $permission_name]);
        }
    }
}
