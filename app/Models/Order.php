<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'quotation_id',
        'brick_product_id',
        'quantity',
        'delivery_address',
        'notes',
        'total_amount',
        'order_status',
    ];

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'quantity'     => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }

    /** Direct-order product (when no quotation is linked) */
    public function directProduct(): BelongsTo
    {
        return $this->belongsTo(BrickProduct::class, 'brick_product_id');
    }

    /** Resolves the product regardless of order type */
    public function getResolvedProductAttribute(): ?BrickProduct
    {
        return $this->quotation?->product ?? $this->directProduct;
    }

    public function isDirectOrder(): bool
    {
        return is_null($this->quotation_id);
    }

    public function tracking(): HasMany
    {
        return $this->hasMany(OrderTracking::class)->latest();
    }

    public function latestTracking(): HasMany
    {
        return $this->hasMany(OrderTracking::class)->latest()->limit(1);
    }

    public static function statusLabel(string $status): string
    {
        return match ($status) {
            'pending'      => 'Pending',
            'confirmed'    => 'Confirmed',
            'in_production' => 'In Production',
            'ready'        => 'Ready for Pickup',
            'delivered'    => 'Delivered',
            default        => ucfirst($status),
        };
    }

    public static function allStatuses(): array
    {
        return ['pending', 'confirmed', 'in_production', 'ready', 'delivered'];
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statusLabel($this->order_status);
    }
}
