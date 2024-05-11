<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $guardName = config('auth.defaults.guard');

        $permissions = [
            'create_team', 'edit_team', 'delete_team', 'delete_fantasy_team',
            'create_player', 'edit_player', 'delete_player',
            'create_division', 'edit_division', 'delete_division',
        ];

        $roles = [
            'admin' => [
                'create_team',
                'edit_team',
                'delete_team',
                'delete_fantasy_team',
                'create_player',
                'edit_player',
                'delete_player',
                'create_division',
                'edit_division',
                'delete_division',
            ],
            'moderator' => ['edit_team', 'edit_player', 'edit_division'],
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        foreach ($roles as $roleName => $permissionNames) {
            $roleId = DB::table('roles')->insertGetId(['name' => $roleName, 'guard_name' => $guardName]);

            foreach ($permissionNames as $permissionName) {
                $permissionId = Permission::where('name', $permissionName)->first()->id;
                DB::table('role_has_permissions')->insert(['role_id' => $roleId, 'permission_id' => $permissionId]);
            }
        }
    }
}
