<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ManageUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:manage {action} {email?} {--name=} {--password=} {--role=admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage users (create, promote, demote, list, delete)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');

        return match($action) {
            'create' => $this->createUser(),
            'promote' => $this->promoteUser(),
            'demote' => $this->demoteUser(),
            'list' => $this->listUsers(),
            'delete' => $this->deleteUser(),
            'make-super' => $this->makeSuperAdmin(),
            default => $this->showHelp()
        };
    }

    private function createUser()
    {
        $email = $this->argument('email') ?: $this->ask('Enter email:');
        $name = $this->option('name') ?: $this->ask('Enter name:');
        $password = $this->option('password') ?: $this->secret('Enter password:');
        $role = $this->option('role');

        // Validate inputs
        if (User::where('email', $email)->exists()) {
            $this->error("User with email '{$email}' already exists.");
            return 1;
        }

        // Validate password
        $validator = Validator::make(['password' => $password], [
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/'
            ]
        ]);

        if ($validator->fails()) {
            $this->error('Password must be at least 8 characters with uppercase, lowercase, number, and special character.');
            return 1;
        }

        // Create user
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $role
        ]);

        $this->info("User created successfully!");
        $this->table(['ID', 'Name', 'Email', 'Role'], [
            [$user->id, $user->name, $user->email, $user->role_display]
        ]);

        return 0;
    }

    private function promoteUser()
    {
        $email = $this->argument('email') ?: $this->ask('Enter user email to promote:');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return 1;
        }

        if ($user->role === 'super_admin') {
            $this->info("User '{$user->name}' is already a super admin.");
            return 0;
        }

        $user->update(['role' => 'super_admin']);
        $this->info("User '{$user->name}' has been promoted to Super Admin.");

        return 0;
    }

    private function demoteUser()
    {
        $email = $this->argument('email') ?: $this->ask('Enter user email to demote:');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return 1;
        }

        if ($user->role === 'admin') {
            $this->info("User '{$user->name}' is already a regular admin.");
            return 0;
        }

        $user->update(['role' => 'admin']);
        $this->info("User '{$user->name}' has been demoted to Admin.");

        return 0;
    }

    private function listUsers()
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->info('No users found.');
            return 0;
        }

        $tableData = $users->map(function ($user) {
            return [
                $user->id,
                $user->name,
                $user->email,
                $user->role_display,
                $user->created_at->format('Y-m-d H:i:s')
            ];
        })->toArray();

        $this->table(['ID', 'Name', 'Email', 'Role', 'Created'], $tableData);

        return 0;
    }

    private function deleteUser()
    {
        $email = $this->argument('email') ?: $this->ask('Enter user email to delete:');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return 1;
        }

        if (!$this->confirm("Are you sure you want to delete user '{$user->name}' ({$user->email})?")) {
            $this->info('Operation cancelled.');
            return 0;
        }

        $userName = $user->name;
        $user->delete();
        $this->info("User '{$userName}' has been deleted successfully.");

        return 0;
    }

    private function makeSuperAdmin()
    {
        $email = $this->argument('email') ?: $this->ask('Enter email for super admin:');
        $name = $this->option('name') ?: $this->ask('Enter name:');
        $password = $this->option('password') ?: $this->secret('Enter password:');

        // Check if user exists
        $existingUser = User::where('email', $email)->first();

        if ($existingUser) {
            if ($existingUser->isSuperAdmin()) {
                $this->info("User '{$existingUser->name}' is already a super admin.");
                return 0;
            }

            $existingUser->update(['role' => 'super_admin']);
            $this->info("Existing user '{$existingUser->name}' has been promoted to Super Admin.");
            return 0;
        }

        // Validate password
        $validator = Validator::make(['password' => $password], [
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/'
            ]
        ]);

        if ($validator->fails()) {
            $this->error('Password must be at least 8 characters with uppercase, lowercase, number, and special character.');
            return 1;
        }

        // Create super admin
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'super_admin'
        ]);

        $this->info("Super Admin created successfully!");
        $this->table(['ID', 'Name', 'Email', 'Role'], [
            [$user->id, $user->name, $user->email, $user->role_display]
        ]);

        return 0;
    }

    private function showHelp()
    {
        $this->info('Available actions:');
        $this->line('  create       - Create a new user');
        $this->line('  promote      - Promote user to super admin');
        $this->line('  demote       - Demote super admin to admin');
        $this->line('  list         - List all users');
        $this->line('  delete       - Delete a user');
        $this->line('  make-super   - Create or promote to super admin');

        $this->info('');
        $this->info('Examples:');
        $this->line('  php artisan user:manage create admin@example.com --name="Admin User" --password="SecurePass123!" --role=admin');
        $this->line('  php artisan user:manage make-super superadmin@example.com --name="Super Admin"');
        $this->line('  php artisan user:manage promote admin@example.com');
        $this->line('  php artisan user:manage list');

        return 0;
    }
}
