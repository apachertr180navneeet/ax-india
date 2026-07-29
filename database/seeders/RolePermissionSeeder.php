<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'view videos', 'create videos', 'edit videos', 'delete videos', 'approve videos',
            'view comments', 'create comments', 'edit comments', 'delete comments', 'moderate comments',
            'view reports', 'manage reports',
            'manage users', 'manage categories',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $moderator = Role::create(['name' => 'moderator']);
        $moderator->givePermissionTo([
            'view videos', 'approve videos',
            'view comments', 'moderate comments',
            'view reports', 'manage reports',
        ]);

        $user = Role::create(['name' => 'user']);
        $user->givePermissionTo([
            'view videos', 'create videos', 'edit videos', 'delete videos',
            'view comments', 'create comments', 'edit comments', 'delete comments',
        ]);
    }
}
