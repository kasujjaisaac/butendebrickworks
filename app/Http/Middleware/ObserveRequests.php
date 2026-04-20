<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ObserveRequests
{
    public function handle(Request $request, Closure $next): Response
    {
        $startedAt = microtime(true);
        $requestId = $request->headers->get('X-Request-Id') ?: (string) Str::uuid();

        $request->attributes->set('request_id', $requestId);

        $sharedContext = [
            'request_id' => $requestId,
            'request_method' => $request->method(),
            'request_path' => '/'.ltrim($request->path(), '/'),
            'request_ip' => $request->ip(),
            'release' => env('APP_RELEASE'),
        ];

        Log::shareContext($sharedContext);

        try {
            $response = $next($request);
        } catch (Throwable $e) {
            $durationMs = $this->durationMs($startedAt);

            Log::channel('monitoring')->error('Unhandled request exception.', [
                ...$sharedContext,
                'route_name' => $request->route()?->getName(),
                'user_id' => Auth::id(),
                'duration_ms' => $durationMs,
                'exception_class' => $e::class,
                'exception_message' => $e->getMessage(),
            ]);

            throw $e;
        }

        $response->headers->set('X-Request-Id', $requestId);

        $durationMs = $this->durationMs($startedAt);
        $context = [
            ...$sharedContext,
            'route_name' => $request->route()?->getName(),
            'user_id' => Auth::id(),
            'duration_ms' => $durationMs,
            'status_code' => $response->getStatusCode(),
        ];

        if ($response->getStatusCode() >= 500) {
            Log::channel('monitoring')->error('Request completed with a server error.', $context);
        } elseif ($durationMs >= (int) config('monitoring.slow_request_threshold_ms', 1500)) {
            Log::channel('monitoring')->warning('Slow request detected.', $context);
        }

        return $response;
    }

    private function durationMs(float $startedAt): int
    {
        return (int) round((microtime(true) - $startedAt) * 1000);
    }
}
