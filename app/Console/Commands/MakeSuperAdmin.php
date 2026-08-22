<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MakeSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:superadmin
                            {name? : The name of the super admin}
                            {email? : The email of the super admin}
                            {--password= : The password for the super admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new super admin user or promote an existing user to super admin';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = $this->argument('name') ?: $this->ask('Enter the super admin name');
        $email = $this->argument('email') ?: $this->ask('Enter the super admin email');
        $password = $this->option('password') ?: $this->ask('Enter the super admin password');

        // Check if a user with this email already exists
        $existingUser = User::where('email', $email)->first();

        if ($existingUser) {
            if ($existingUser->isSuperAdmin()) {
                $this->info("User '{$existingUser->name}' ({$existingUser->email}) is already a super admin.");

                return 0;
            }

            $existingUser->update(['role' => 'super_admin']);
            $this->info("Existing user '{$existingUser->name}' has been promoted to Super Admin.");

            $this->table(['ID', 'Name', 'Email', 'Role'], [
                [$existingUser->id, $existingUser->name, $existingUser->email, $existingUser->role_display],
            ]);

            return 0;
        }

        // Validate inputs for a new user
        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/',
            ],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return 1;
        }

        // Create the super admin
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'super_admin',
        ]);

        $this->info('Super Admin created successfully!');
        $this->table(['ID', 'Name', 'Email', 'Role'], [
            [$user->id, $user->name, $user->email, $user->role_display],
        ]);

        return 0;
    }
}
