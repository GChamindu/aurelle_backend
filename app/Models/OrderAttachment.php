<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderAttachment extends Model
{
    protected $fillable = [
        'order_id',
        'file_name',
        'file_path',
        'file_hash',
        'mime_type',
        'file_size',
    ];

      public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
