<?php

use App\Support\ProductCalculatorMetrics;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('brick_products')
            ->select(['id', 'coverage_sqm', 'bricks_per_square_metre'])
            ->orderBy('id')
            ->lazy()
            ->each(function ($product): void {
                $normalized = ProductCalculatorMetrics::normalize(
                    $product->coverage_sqm !== null ? (float) $product->coverage_sqm : null,
                    $product->bricks_per_square_metre !== null ? (int) $product->bricks_per_square_metre : null,
                );

                if (! $normalized) {
                    return;
                }

                DB::table('brick_products')
                    ->where('id', $product->id)
                    ->update($normalized);
            });
    }

    public function down(): void
    {
        //
    }
};
