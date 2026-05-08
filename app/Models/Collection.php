<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    protected $table = 'collections';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'image',
        // 'is_active',
        'show_in_header'
    ];




    public function products()
    {
        return $this->belongsToMany(Product::class, 'collection_product');
    }
}
