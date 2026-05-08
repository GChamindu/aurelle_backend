<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewOrderAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $orderItems;
    public array $customer;
    public string $adminLink;

    public function __construct(array $orderItems, array $customer, string $adminLink = 'https://admin.aurelle.lk')
    {
        $this->orderItems = $orderItems;   // array of products
        $this->customer = $customer;       // customer info
        $this->adminLink = $adminLink;     // admin dashboard link
    }

    public function build()
    {
        $firstProduct = $this->orderItems[0] ?? ['product_id' => '', 'title' => ''];
        $subject = "New Order: {$firstProduct['product_id']} - {$firstProduct['title']} by {$this->customer['name']}";

        return $this->markdown('emails.orders.admin')
                    ->subject($subject)
                    ->with([
                        'orderItems' => $this->orderItems,
                        'customer'   => $this->customer,
                        'adminLink'  => $this->adminLink,
                    ]);
    }
}
