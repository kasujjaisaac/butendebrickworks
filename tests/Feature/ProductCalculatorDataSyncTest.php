<?php

use App\Models\BrickProduct;

it('can preview calculator metric repairs without writing changes', function () {
    $product = BrickProduct::create([
        'name' => 'Legacy Floor Tile',
        'coverage_sqm' => 0.25,
        'bricks_per_square_metre' => 60,
        'price_per_brick' => 1200,
        'is_active' => true,
    ]);

    $this->artisan('products:sync-calculator-data --dry-run')
        ->assertExitCode(0);

    $product->refresh();

    expect((float) $product->coverage_sqm)->toBe(0.25)
        ->and($product->bricks_per_square_metre)->toBe(60);
});

it('normalizes calculator metrics into a canonical pair', function () {
    $product = BrickProduct::create([
        'name' => 'Legacy Floor Tile',
        'coverage_sqm' => 0.25,
        'bricks_per_square_metre' => 60,
        'price_per_brick' => 1200,
        'is_active' => true,
    ]);

    $this->artisan('products:sync-calculator-data')
        ->assertExitCode(0);

    $product->refresh();

    expect((float) $product->coverage_sqm)->toBe(0.25)
        ->and($product->bricks_per_square_metre)->toBe(4);
});
