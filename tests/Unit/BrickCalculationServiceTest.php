<?php

use App\Models\BrickProduct;
use App\Services\BrickCalculationService;

it('normalizes legacy coverage values that were entered as units per square metre', function () {
    $product = new BrickProduct([
        'coverage_sqm' => 60,
        'bricks_per_square_metre' => 60,
    ]);

    expect($product->coverage)->toBe(round(1 / 60, 6))
        ->and($product->units_per_square_metre)->toBe(60);
});

it('prefers a real coverage-per-unit value when one is stored', function () {
    $product = new BrickProduct([
        'coverage_sqm' => 0.25,
        'bricks_per_square_metre' => 60,
    ]);

    expect($product->coverage)->toBe(0.25)
        ->and($product->units_per_square_metre)->toBe(4);
});

it('calculates the correct quantity for one square metre from units-per-square-metre data', function () {
    $service = new BrickCalculationService();
    $product = new BrickProduct([
        'coverage_sqm' => 60,
        'bricks_per_square_metre' => 60,
        'price_per_brick' => 1200,
    ]);

    $result = $service->calculateForProduct(1, $product);

    expect($result['bricks_required'])->toBe(60)
        ->and($result['total_price'])->toBe(72000.0);
});
