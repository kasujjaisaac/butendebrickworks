<?php

use App\Models\BrickProduct;
use App\Models\ProductCategory;

function createCatalogProduct(ProductCategory $category, array $overrides = []): BrickProduct
{
    return BrickProduct::create(array_merge([
        'name' => 'Plain Brick',
        'category_id' => $category->id,
        'description' => 'Durable fired clay unit for structural walling.',
        'price_per_brick' => 1200,
        'bricks_per_square_metre' => 60,
        'weight_kg' => 3.5,
        'dimensions_inch' => '9 x 4 1/2 x 3',
        'coverage_sqm' => 0.016667,
        'is_active' => true,
    ], $overrides));
}

it('renders the products catalogue for category-backed products', function () {
    $bricks = ProductCategory::create(['name' => 'Bricks']);
    $tiles = ProductCategory::create(['name' => 'Floor Tiles']);

    createCatalogProduct($bricks);
    createCatalogProduct($tiles, [
        'name' => 'Courtyard Tile',
        'description' => 'Hard-wearing clay tile for courtyards and verandas.',
    ]);

    $this->get('/products')
        ->assertOk()
        ->assertSeeText('Our Products')
        ->assertSeeText('Bricks')
        ->assertSeeText('Floor Tiles')
        ->assertSeeText('Plain Brick')
        ->assertSeeText('Courtyard Tile');
});

it('renders the category page for category-backed products', function () {
    $bricks = ProductCategory::create(['name' => 'Bricks']);

    createCatalogProduct($bricks, ['name' => 'Standard Brick Grooved']);

    $this->get('/products/bricks')
        ->assertOk()
        ->assertSeeText('Bricks')
        ->assertSeeText('Standard Brick Grooved');
});
