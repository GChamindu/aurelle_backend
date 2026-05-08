<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductSearchIndex extends Model
{
    protected $table = 'product_search_indexes';

    protected $fillable = ['product_id', 'search_text'];



}
