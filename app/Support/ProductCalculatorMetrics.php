<?php

namespace App\Support;

final class ProductCalculatorMetrics
{
    /**
     * Normalize calculator fields into a canonical pair.
     *
     * coverage_sqm is stored as "area covered by one unit".
     * bricks_per_square_metre is stored as "units required for one square metre".
     */
    public static function normalize(?float $coverageSqm, ?int $unitsPerSquareMetre): ?array
    {
        $resolvedUnits = self::resolveUnitsPerSquareMetre($coverageSqm, $unitsPerSquareMetre);

        if ($resolvedUnits <= 0) {
            return null;
        }

        return [
            'coverage_sqm' => round(1 / $resolvedUnits, 6),
            'bricks_per_square_metre' => $resolvedUnits,
        ];
    }

    public static function resolveCoverage(?float $coverageSqm, ?int $unitsPerSquareMetre): float
    {
        return self::normalize($coverageSqm, $unitsPerSquareMetre)['coverage_sqm'] ?? 0.0;
    }

    public static function resolveUnitsPerSquareMetre(?float $coverageSqm, ?int $unitsPerSquareMetre): int
    {
        if ($coverageSqm !== null && $coverageSqm > 0 && $coverageSqm <= 1) {
            return max(1, (int) round(1 / $coverageSqm));
        }

        if ($unitsPerSquareMetre !== null && $unitsPerSquareMetre > 0) {
            return $unitsPerSquareMetre;
        }

        if ($coverageSqm !== null && $coverageSqm > 1) {
            return max(1, (int) round($coverageSqm));
        }

        return 0;
    }
}
