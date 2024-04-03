<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $guardName = config('auth.defaults.guard');

        $createTeamPermission = Permission::create(['name' => 'create_team']);
        $editTeamPermission = Permission::create(['name' => 'edit_team']);
        $deleteTeamPermission = Permission::create(['name' => 'delete_team']);

        DB::table('roles')->insert([
            ['name' => 'admin', 'guard_name' => $guardName],
            ['name' => 'team_owner', 'guard_name' => $guardName],
        ]);

        DB::table('role_has_permissions')->insert([
            ['role_id' => 1, 'permission_id' => $createTeamPermission->id],
            ['role_id' => 2, 'permission_id' => $editTeamPermission->id],
            ['role_id' => 1, 'permission_id' => $deleteTeamPermission->id],
        ]);

    }
}
