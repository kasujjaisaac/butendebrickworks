<?php

namespace App\Http\Controllers;

use App\Services\HealthCheckService;
use Illuminate\Http\JsonResponse;

class HealthCheckController extends Controller
{
    public function __invoke(HealthCheckService $health): JsonResponse
    {
        $summary = $health->summary();

        return response()->json(
            $summary,
            $summary['ok'] ? 200 : 503,
        );
    }
}
