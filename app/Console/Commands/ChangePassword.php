<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ChangePassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = \App\Models\User::all(['id', 'name', 'email']);
        if ($users->isEmpty()) {
            $this->error('No users found.');
            return;
        }

        $choices = $users->map(function ($user) {
            return "{$user->id}: {$user->name} <{$user->email}>";
        })->toArray();

        $selected = $this->choice('Select a user to change password', $choices);

        $userId = intval(explode(':', $selected)[0]);
        $user = $users->where('id', $userId)->first();

        if (!$user) {
            $this->error('User not found.');
            return;
        }

        $password = $this->secret('Enter new password');
        $passwordConfirm = $this->secret('Confirm new password');

        if ($password !== $passwordConfirm) {
            $this->error('Passwords do not match.');
            return;
        }

        $user->password = \Hash::make($password);
        $user->save();

        $this->info("Password changed for user {$user->name} ({$user->email}).");
    }
}
