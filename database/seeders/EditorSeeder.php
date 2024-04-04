<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class EditorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $editor = User::updateOrCreate(
                [
                    'email' => 'editor@example.com',
                ],
                [
                    'first_name' => 'Editor',
                    'last_name' => 'Editor',
                    'password' => bcrypt('password'),
                ]
            );
            $editorRole = Role::updateOrCreate(['name' => 'Editor']);

            $editor2 = User::updateOrCreate(
                [
                    'email' => 'secondeditor@example.com',
                ],
                [
                    'first_name' => 'Second',
                    'last_name' => 'Editor',
                    'password' => bcrypt('password'),
                ]
            );

            $editor->assignRole('Editor');
            $editor2->assignRole('Editor');
            $editorRole->syncPermissions(['create posts',
                'update posts',
                'delete posts',
                'create comments',
                'delete comments']);
        }
    }
}
