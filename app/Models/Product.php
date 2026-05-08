<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    // protected $fillable = ['name', 'slug', 'description', 'base_price', 'category_id', 'show_areas', 'keywords', 'main_image', 'hover_image'];

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'base_price',
        // 'main_image',
        // 'hover_image',
        'show_areas',
        'status',
        'keywords',
        'product_id',
        'size_chart_image',
        'old_price',
    ];
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }


    //     public function showAreas()
    // {
    //     return $this->belongsToMany(ShowArea::class);
    // }

    public function showAreas()
    {
        return $this->belongsToMany(ShowArea::class, 'product_show_area', 'product_id', 'show_area_id');
    }


    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'collection_product');
    }

    public function sections()
    {
        return $this->belongsToMany(NewSection::class, 'section_product', 'product_id', 'section_id');
    }



    // public function category()
    // {
    //     return $this->belongsTo(Category::class);
    // }


  public function categories()
{
    return $this->belongsToMany(Category::class)
                ->withTimestamps();
}



    // protected $casts = [
    //     'show_areas' => 'array',
    //     'keywords'   => 'array',
    // ];


    // public function getShowAreaAttribute($value)
    // {
    //     return is_string($value) ? json_decode($value, true) : $value;
    // }
}
