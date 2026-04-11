<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BrickProduct extends Model
{
    protected $fillable = [
        'name',
        'category',
        'description',
        'image',
        'weight_kg',
        'dimensions_inch',
        'coverage_sqm',
        'price_per_brick',
        'bricks_per_square_metre',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'price_per_brick'         => 'decimal:2',
            'bricks_per_square_metre' => 'integer',
            'weight_kg'               => 'decimal:2',
            'coverage_sqm'            => 'decimal:6',
            'is_active'               => 'boolean',
        ];
    }

    /**
     * The effective coverage per unit in sqm.
     * Prefers the explicit coverage_sqm column; falls back to deriving from bricks_per_square_metre.
     */
    public function getCoverageAttribute(): float
    {
        if ($this->coverage_sqm && $this->coverage_sqm > 0) {
            return (float) $this->coverage_sqm;
        }

        if ($this->bricks_per_square_metre > 0) {
            return round(1 / $this->bricks_per_square_metre, 6);
        }

        return 0;
    }

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Return dimensions_inch with common fraction strings replaced by Unicode fraction characters.
     * e.g. "9 x 4 1/2 x 3" → "9 x 4½ x 3"
     */
    public function getFormattedDimensionsAttribute(): ?string
    {
        if (! $this->dimensions_inch) {
            return null;
        }

        $fractions = [
            '1/8' => '⅛',
            '1/4' => '¼',
            '3/8' => '⅜',
            '1/2' => '½',
            '5/8' => '⅝',
            '3/4' => '¾',
            '7/8' => '⅞',
            '1/3' => '⅓',
            '2/3' => '⅔',
            '1/6' => '⅙',
            '5/6' => '⅚',
        ];

        $dim = $this->dimensions_inch;

        foreach ($fractions as $plain => $unicode) {
            // "2 1/2" → "2½" (digit-space-fraction merged)
            $dim = preg_replace('/(\d)\s+' . preg_quote($plain, '/') . '/', '$1' . $unicode, $dim);
            // standalone "1/2" → "½"
            $dim = str_replace($plain, $unicode, $dim);
        }

        return $dim;
    }
}
