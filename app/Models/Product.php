<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'tags',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'tags' => 'array',
        ];
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
