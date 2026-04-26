<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class ResetAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Usage:
     * php artisan admin:reset-password admin@example.com
     * php artisan admin:reset-password admin@example.com "new-secret-password"
     */
    protected $signature = 'admin:reset-password
        {email : Admin user email}
        {password? : New password (optional; prompted if omitted)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset password for an admin user by email';

    public function handle(): int
    {
        $email = strtolower(trim((string) $this->argument('email')));
        $password = (string) ($this->argument('password') ?? '');

        if ($password === '') {
            $password = (string) $this->secret('Enter new password (min 8 chars)');
        }

        if ($password === '') {
            $this->error('Password is required.');

            return self::FAILURE;
        }

        $confirmation = (string) $this->secret('Confirm new password');

        if ($password !== $confirmation) {
            $this->error('Password confirmation does not match.');

            return self::FAILURE;
        }

        $validator = Validator::make(
            ['email' => $email, 'password' => $password],
            ['email' => ['required', 'email'], 'password' => ['required', 'string', 'min:8']]
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $user = User::query()
            ->where('email', $email)
            ->where('is_admin', true)
            ->first();

        if (! $user) {
            $this->error("No active admin user found for email: {$email}");

            return self::FAILURE;
        }

        // Password will be hashed via User model cast.
        $user->password = $password;
        $user->save();

        $this->info("Admin password reset successfully for: {$email}");

        return self::SUCCESS;
    }
}
// Usage:

// Interactive password prompt:
// php artisan admin:reset-password admin@votafrica.com

// Provide password inline:
// php artisan admin:reset-password admin@votafrica.com "new-password-123"

// What it does:

// Validates email format
// Ensures password is at least 8 characters
// Confirms password before saving
// Finds only users with is_admin = true
// Updates password securely (hashed via User model cast)
