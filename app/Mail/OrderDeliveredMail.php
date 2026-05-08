<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderDeliveredMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $order;

    public function __construct(array $orderData)
    {
        $this->order = $orderData;
    }

    public function build()
    {
        return $this->markdown('emails.orders.delivered')
            ->subject('Your Order has been Delivered 🎉')
            ->with(['order' => $this->order]);
    }
}
