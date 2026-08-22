<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:change-password {email} {--password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change password for a user by email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->option('password');

        // Find user by email
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return 1;
        }

        // Get password if not provided
        if (!$password) {
            $password = $this->secret('Enter new password for ' . $user->name . ':');

            if (empty($password)) {
                $this->error('Password cannot be empty.');
                return 1;
            }

            $confirmPassword = $this->secret('Confirm new password:');

            if ($password !== $confirmPassword) {
                $this->error('Passwords do not match.');
                return 1;
            }
        }

        // Validate password strength
        $validator = Validator::make(['password' => $password], [
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/'
            ]
        ]);

        if ($validator->fails()) {
            $this->error('Password must be at least 8 characters long and contain uppercase, lowercase, number, and special character.');
            return 1;
        }

        // Update password
        $user->update([
            'password' => Hash::make($password)
        ]);

        $this->info("Password successfully changed for user: {$user->name} ({$user->email})");

        // Log the password change
        $this->info("Password change logged at: " . now());

        return 0;
    }
}
