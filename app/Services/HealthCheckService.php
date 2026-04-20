<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Throwable;

class HealthCheckService
{
    public function summary(): array
    {
        $checks = [
            'app_key' => $this->checkAppKey(),
            'database' => $this->checkDatabase(),
            'cache' => $this->checkCache(),
            'storage' => $this->checkStorage(),
            'storage_link' => $this->checkStorageLink(),
        ];

        return [
            'ok' => collect($checks)->every(fn (array $check) => $check['status'] !== 'fail'),
            'app' => config('app.name'),
            'env' => app()->environment(),
            'release' => env('APP_RELEASE'),
            'checked_at' => now()->toIso8601String(),
            'checks' => $checks,
        ];
    }

    public function logIfUnhealthy(array $summary): void
    {
        if ($summary['ok']) {
            return;
        }

        Log::channel('monitoring')->error('Health check failed.', [
            'env' => $summary['env'],
            'release' => $summary['release'],
            'checks' => $summary['checks'],
        ]);
    }

    private function checkAppKey(): array
    {
        return [
            'status' => filled(config('app.key')) ? 'ok' : 'fail',
            'message' => filled(config('app.key'))
                ? 'Application key is configured.'
                : 'APP_KEY is missing.',
        ];
    }

    private function checkDatabase(): array
    {
        try {
            DB::select('select 1');

            $requiredTables = collect([
                'migrations',
                'users',
                'brick_products',
                'product_categories',
                'quotations',
                'orders',
            ]);

            $missingTables = $requiredTables
                ->reject(fn (string $table) => Schema::hasTable($table))
                ->values()
                ->all();

            if ($missingTables !== []) {
                return [
                    'status' => 'fail',
                    'message' => 'Database is reachable, but required tables are missing: '.implode(', ', $missingTables).'.',
                ];
            }

            return [
                'status' => 'ok',
                'message' => 'Database connection is healthy on ['.DB::getDefaultConnection().'].',
            ];
        } catch (Throwable $e) {
            return [
                'status' => 'fail',
                'message' => 'Database check failed: '.$e->getMessage(),
            ];
        }
    }

    private function checkCache(): array
    {
        try {
            $key = 'health-check:'.Str::uuid();

            Cache::put($key, 'ok', 60);
            $healthy = Cache::get($key) === 'ok';
            Cache::forget($key);

            return [
                'status' => $healthy ? 'ok' : 'fail',
                'message' => $healthy
                    ? 'Cache store ['.config('cache.default').'] is writable.'
                    : 'Cache round-trip failed.',
            ];
        } catch (Throwable $e) {
            return [
                'status' => 'fail',
                'message' => 'Cache check failed: '.$e->getMessage(),
            ];
        }
    }

    private function checkStorage(): array
    {
        $paths = [
            'logs' => storage_path('logs'),
            'public_disk' => config('filesystems.disks.public.root', storage_path('app/public')),
        ];

        $problems = collect($paths)->map(function (string $path, string $name): ?string {
            if (! is_dir($path)) {
                return "{$name} directory is missing at {$path}.";
            }

            if (! is_writable($path)) {
                return "{$name} directory is not writable at {$path}.";
            }

            return null;
        })->filter()->values()->all();

        return [
            'status' => $problems === [] ? 'ok' : 'fail',
            'message' => $problems === []
                ? 'Storage paths are present and writable.'
                : implode(' ', $problems),
        ];
    }

    private function checkStorageLink(): array
    {
        $linkPath = public_path('storage');

        return [
            'status' => file_exists($linkPath) ? 'ok' : 'warn',
            'message' => file_exists($linkPath)
                ? 'Public storage path is available.'
                : 'public/storage is missing. Run [php artisan storage:link] after deploy if product images are broken.',
        ];
    }
}
