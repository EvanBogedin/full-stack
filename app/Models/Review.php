<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'review',
        'honesty_score',
        'user_id',
        'product_id'
    ];
}
