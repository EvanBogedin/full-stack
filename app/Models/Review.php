<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'review',
        'honesty_score',
        'user_id',
        'product_id',
        'likes_count',
        'dislikes_count',
    ];

    protected function casts(): array
    {
        return [
            'honesty_score' => 'float',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function reactions(): HasMany
    {
        return $this->hasMany(ReviewReaction::class);
    }
}
