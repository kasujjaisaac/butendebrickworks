<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Command\Command;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('admin:create {email?} {--name=} {--password=}', function (?string $email = null) {
    $email ??= $this->ask('Admin email');
    $name = $this->option('name') ?: $this->ask('Admin name');
    $password = $this->option('password') ?: $this->secret('Admin password');

    if (! $email || ! $name || ! $password) {
        $this->error('Name, email, and password are required.');

        return Command::FAILURE;
    }

    $user = User::query()->updateOrCreate(
        ['email' => $email],
        [
            'name' => $name,
            'password' => $password,
            'is_admin' => true,
            'email_verified_at' => now(),
        ],
    );

    $this->info("Admin account ready for {$user->email}.");

    return Command::SUCCESS;
})->purpose('Create or promote an admin user for the private dashboard');
