<?php

namespace App\Models;

use App\Enums\OrderItemStatus;
use App\Jobs\SendOrderDeliveredEmail;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        'user_id',
        'order_number',
        'subtotal',
        'shipping_cost',
        'total_amount',
        'payment_method',
        'payment_status',
        'order_status',
        'note',
    ];

    /* -----------------------------
     | Relationships
     ----------------------------- */

    // ONE order has ONE address
    public function address()
    {
        return $this->hasOne(OrderAddress::class);
    }

    // ONE order has MANY items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Auto calculate order status from item statuses
     */
    public function refreshStatusFromItems(bool $sendMail = true): void
    {
        $items = $this->items;

        // Check if all items are delivered
        if ($items->isNotEmpty() && $items->every(fn($i) => $i->status === OrderItemStatus::DELIVERED)) {
            $this->order_status = OrderItemStatus::DELIVERED;

            // Send mail only once
            if ($sendMail) {
                dispatch(new SendOrderDeliveredEmail($this));
            }

            $this->save(); // Save ONLY if status changed
        }
    }

    public function attachments()
    {
        return $this->hasMany(OrderAttachment::class, 'order_id');
    }
}
