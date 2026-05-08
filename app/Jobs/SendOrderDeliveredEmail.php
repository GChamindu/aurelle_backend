<?php

namespace App\Jobs;

use App\Mail\OrderDeliveredMail;
use App\Models\Order;
use App\Helpers\R2Helper;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendOrderDeliveredEmail implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public array $orderData;

    public function __construct(Order $order)
    {
        // Prepare the dataset for email



        $productsSubtotal = $order->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $totalPrice = $productsSubtotal + 350;

        $this->orderData = [
            'id' => $order->id,
            'order_number' => $order->order_number,
            'invoice_date' => $order->created_at->format('Y-m-d'),
            'expected_delivery' => now()->addDays(3)->format('Y-m-d'), // Example
            'subtotal' => number_format($order->subtotal, 2),
            'shipping' => number_format($order->shipping, 2),
            'tax' => number_format($order->tax, 2),
            'total' => number_format($totalPrice, 2),
            'subtotal' => number_format($productsSubtotal, 2),
            'address' => [
                'name' => $order->address?->name,
                'email' => $order->address?->email,
                'address' => $order->address?->address,
                'city' => $order->address?->city,
                'state' => $order->address?->state,
                'zip' => $order->address?->zip,
            ],
            'items' => $order->items->map(function ($item) {
                // Get the first product image and generate R2 URL
                $imagePath = $item->product?->images->first()?->image_path;
                $imageUrl = $imagePath ? R2Helper::getFileUrl($imagePath) : null;

                return [
                    'name' => $item->product?->name,
                    'quantity' => $item->quantity,
                    'size' => $item->size?->name ?? '-',
                    'color' => $item->color?->name ?? '-',
                    'price' => number_format($item->price * $item->quantity, 2),
                    'image_url' => $imageUrl,
                ];
            })->toArray(),
        ];
    }

    public function handle(): void
    {
        if (empty($this->orderData['address']['email'])) {
            return;
        }

        Mail::to($this->orderData['address']['email'])
            ->send(new OrderDeliveredMail($this->orderData));
    }
}
