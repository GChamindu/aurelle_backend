<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewSection extends Model
{
    protected $table = 'new_sections';

    protected $fillable = [
        'name',
        'slug',
        'status',
    ];


    public function products()
    {
        return $this->belongsToMany(
            \App\Models\Product::class,
            'section_product',
            'section_id',
            'product_id'
        );
    }
}
