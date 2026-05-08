<?php

namespace App\Models;

use App\Enums\ProductImageType;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'color_id',
        'image_path',
        'image_type',
    ];


    protected $casts = [
        'image_type' => ProductImageType::class,
    ];

    public function color()
    {
        return $this->belongsTo(Coloer::class, 'color_id');
    }
}
