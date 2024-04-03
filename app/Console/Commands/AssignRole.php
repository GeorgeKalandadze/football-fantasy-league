<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class AssignRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:assign-role {email} {role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign a role to a user';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->argument('email');
        $roleName = $this->argument('role');

        $user = User::where('email', $email)->first();
        if (! $user) {
            $this->error('User not found.');

            return;
        }

        $role = Role::where('name', $roleName)->first();
        if (! $role) {
            $this->error('Role not found.');

            return;
        }

        $user->assignRole($role);

        $this->info("Role '{$roleName}' assigned to user '{$email}'.");
    }
}
