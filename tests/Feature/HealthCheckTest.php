<?php

it('returns a healthy monitoring payload', function () {
    $this->get('/health')
        ->assertOk()
        ->assertJsonPath('ok', true)
        ->assertJsonStructure([
            'ok',
            'app',
            'env',
            'release',
            'checked_at',
            'checks' => [
                'app_key',
                'database',
                'cache',
                'storage',
                'storage_link',
            ],
        ]);
});

it('reports healthy status from the console command', function () {
    $this->artisan('health:check --json')
        ->assertExitCode(0);
});

it('adds a request id header to health responses', function () {
    $this->withHeaders([
        'X-Request-Id' => 'test-request-id-123',
    ])->get('/health')
        ->assertOk()
        ->assertHeader('X-Request-Id', 'test-request-id-123');
});
