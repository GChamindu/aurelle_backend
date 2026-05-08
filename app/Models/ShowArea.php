<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShowArea extends Model
{
    protected $fillable = [
        'key',
        'name',
        'is_active',
        'priority',
    ];

    // public function products()
    // {
    //     return $this->belongsToMany(Product::class);
    // }

    public function products()
{
    return $this->belongsToMany(
        Product::class,
        'product_show_area'
    );
}



}
