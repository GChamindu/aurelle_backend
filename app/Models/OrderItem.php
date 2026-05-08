<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'title',
        'price',
        'quantity',
        'color_id',
        'size_id',
        'status',
    ];

    public const STATUSES = [
        'pending',
        'inprogress',
        'delivered',
        'cancelled',
    ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function color()
    {
        return $this->belongsTo(Coloer::class);
    }
}
