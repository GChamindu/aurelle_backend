<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\ProductVariantAvailabilityStatus;

class ProductVariantAvailability extends Model
{
    protected $fillable = [
        'product_id',
        'color_id',
        'size_id',
        'status',
    ];

    protected $casts = [
        'status' => ProductVariantAvailabilityStatus::class,
    ];
}
