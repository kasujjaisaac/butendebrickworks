<?php

namespace App\Services;

use App\Models\BrickProduct;

class BrickCalculationService
{
    /**
     * Calculate units required and total price from a BrickProduct.
     *
     * Uses the normalized model accessors so both old and new product data calculate correctly.
     *
     * @return array{bricks_required: int, total_price: float}
     */
    public function calculateForProduct(float $squareMetres, BrickProduct $product): array
    {
        $coverage = $product->coverage;
        $unitsPerSquareMetre = $product->units_per_square_metre;

        if ($coverage > 0) {
            $unitsRequired = (int) ceil($squareMetres / $coverage);
        } else {
            $unitsRequired = (int) ceil($squareMetres * $unitsPerSquareMetre);
        }

        $totalPrice = round($unitsRequired * (float) $product->price_per_brick, 2);

        return [
            'bricks_required' => $unitsRequired,
            'total_price'     => $totalPrice,
        ];
    }

    /**
     * Legacy calculate method kept for backward compatibility.
     *
     * @return array{bricks_required: int, total_price: float}
     */
    public function calculate(
        float $squareMetres,
        int $bricksPerSquareMetre,
        float $pricePerBrick
    ): array {
        $bricksRequired = (int) ceil($squareMetres * $bricksPerSquareMetre);
        $totalPrice     = round($bricksRequired * $pricePerBrick, 2);

        return [
            'bricks_required' => $bricksRequired,
            'total_price'     => $totalPrice,
        ];
    }
}
