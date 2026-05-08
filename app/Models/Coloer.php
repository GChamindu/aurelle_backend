<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coloer extends Model
{
    protected $table = 'colors';

    protected $fillable = [
        'name',
        'code',
    ];
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
