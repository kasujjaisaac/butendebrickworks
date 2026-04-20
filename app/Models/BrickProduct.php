<?php

namespace App\Models;

use App\Support\ProductCalculatorMetrics;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BrickProduct extends Model
{
    protected $fillable = [
        'name',
        'category',
        'category_id',
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
     * Relationship to ProductCategory
     */
    public function categoryModel(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    /**
     * Get the category name (for backward compatibility with old 'category' column)
     */
    public function getCategoryAttribute(): ?string
    {
        if ($this->relationLoaded('categoryModel') && $this->categoryModel) {
            return $this->categoryModel->name;
        }

        return $this->categoryModel?->name ?? ($this->attributes['category'] ?? null);
    }

    /**
     * The effective coverage per unit in sqm.
     * Supports both true per-unit coverage values and legacy "units per m²" values
     * that were accidentally stored in coverage_sqm.
     */
    public function getCoverageAttribute(): float
    {
        return ProductCalculatorMetrics::resolveCoverage(
            $this->attributes['coverage_sqm'] ?? null,
            isset($this->attributes['bricks_per_square_metre']) ? (int) $this->attributes['bricks_per_square_metre'] : null,
        );
    }

    /**
     * The effective units required per square metre.
     * Prefers a real coverage-per-unit value when present so stale defaults do not win.
     */
    public function getUnitsPerSquareMetreAttribute(): int
    {
        return ProductCalculatorMetrics::resolveUnitsPerSquareMetre(
            $this->attributes['coverage_sqm'] ?? null,
            isset($this->attributes['bricks_per_square_metre']) ? (int) $this->attributes['bricks_per_square_metre'] : null,
        );
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
