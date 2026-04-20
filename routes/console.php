<?php

use App\Models\BrickProduct;
use App\Models\User;
use App\Services\HealthCheckService;
use App\Support\ProductCalculatorMetrics;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
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

Artisan::command('products:sync-calculator-data {--dry-run : Show the planned changes without writing them}', function () {
    $dryRun = (bool) $this->option('dry-run');
    $changed = 0;
    $unchanged = 0;
    $invalid = 0;
    $previewRows = [];

    BrickProduct::query()
        ->orderBy('id')
        ->get(['id', 'name', 'coverage_sqm', 'bricks_per_square_metre'])
        ->each(function (BrickProduct $product) use ($dryRun, &$changed, &$unchanged, &$invalid, &$previewRows): void {
            $normalized = ProductCalculatorMetrics::normalize(
                $product->coverage_sqm !== null ? (float) $product->coverage_sqm : null,
                $product->bricks_per_square_metre !== null ? (int) $product->bricks_per_square_metre : null,
            );

            if (! $normalized) {
                $invalid++;

                $previewRows[] = [
                    $product->id,
                    $product->name,
                    'invalid',
                    (string) ($product->coverage_sqm ?? 'null'),
                    (string) ($product->bricks_per_square_metre ?? 'null'),
                    'Could not derive calculator metrics.',
                ];

                return;
            }

            $currentCoverage = $product->coverage_sqm !== null ? round((float) $product->coverage_sqm, 6) : null;
            $currentUnits = $product->bricks_per_square_metre !== null ? (int) $product->bricks_per_square_metre : null;
            $needsUpdate = $currentCoverage !== $normalized['coverage_sqm']
                || $currentUnits !== $normalized['bricks_per_square_metre'];

            if (! $needsUpdate) {
                $unchanged++;

                return;
            }

            $changed++;

            $previewRows[] = [
                $product->id,
                $product->name,
                $dryRun ? 'preview' : 'updated',
                (string) ($product->coverage_sqm ?? 'null').' -> '.$normalized['coverage_sqm'],
                (string) ($product->bricks_per_square_metre ?? 'null').' -> '.$normalized['bricks_per_square_metre'],
                'Calculator metrics normalized.',
            ];

            if (! $dryRun) {
                $product->forceFill($normalized)->save();
            }
        });

    if ($previewRows !== []) {
        $this->table(
            ['ID', 'Product', 'Action', 'Coverage', 'Units/m²', 'Note'],
            array_slice($previewRows, 0, 20),
        );

        if (count($previewRows) > 20) {
            $this->comment('Showing the first 20 affected products only.');
        }
    }

    $summary = sprintf(
        '%s complete. %d changed, %d unchanged, %d invalid.',
        $dryRun ? 'Dry run' : 'Sync',
        $changed,
        $unchanged,
        $invalid,
    );

    if ($invalid > 0) {
        $this->warn($summary);
    } else {
        $this->info($summary);
    }

    return $invalid > 0 ? Command::INVALID : Command::SUCCESS;
})->purpose('Normalize product calculator fields so coverage and units per square metre stay consistent');

Artisan::command('health:check {--json : Output the health summary as JSON}', function () {
    $health = app(HealthCheckService::class);
    $summary = $health->summary();

    $health->logIfUnhealthy($summary);

    if ($this->option('json')) {
        $this->line(json_encode($summary, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        return $summary['ok'] ? Command::SUCCESS : Command::FAILURE;
    }

    $this->table(
        ['Check', 'Status', 'Message'],
        collect($summary['checks'])->map(function (array $check, string $name) {
            return [$name, strtoupper($check['status']), $check['message']];
        })->values()->all(),
    );

    $this->line('Checked at: '.$summary['checked_at']);

    if ($summary['ok']) {
        $this->info('System health check passed.');

        return Command::SUCCESS;
    }

    $this->error('System health check failed.');

    return Command::FAILURE;
})->purpose('Verify that the application dependencies required in production are healthy');

Schedule::command('health:check --json')
    ->everyFiveMinutes()
    ->withoutOverlapping();
