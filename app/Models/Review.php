<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'reviewer_name',
        'position',
        'company',
        'photo',
        'rating',
        'content',
        'is_approved',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'rating'      => 'integer',
            'is_approved' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
