<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Quotation extends Model
{
    protected $fillable = [
        'user_id',
        'brick_product_id',
        'square_metres',
        'bricks_required',
        'price_per_brick',
        'total_price',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'square_metres'   => 'decimal:2',
            'bricks_required' => 'integer',
            'price_per_brick' => 'decimal:2',
            'total_price'     => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(BrickProduct::class, 'brick_product_id');
    }

    public function order(): HasOne
    {
        return $this->hasOne(Order::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function hasOrder(): bool
    {
        return $this->order()->exists();
    }
}
