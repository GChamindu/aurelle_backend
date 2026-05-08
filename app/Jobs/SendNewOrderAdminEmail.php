<?php

namespace App\Jobs;

use App\Mail\NewOrderAdminMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewOrderAdminEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $orderItems;
    public array $customer;
    public string $adminLink;

    public function __construct(array $orderItems, array $customer, string $adminLink = 'https://admin.copper.lk')
    {
        $this->orderItems = $orderItems;
        $this->customer = $customer;
        $this->adminLink = $adminLink;
    }

    public function handle(): void
    {
        $adminEmail = config('mail.admin_email', 'admin@copper.lk');

        Mail::to($adminEmail)->send(
            new NewOrderAdminMail(
                $this->orderItems,
                $this->customer,
                $this->adminLink
            )
        );
    }
}
