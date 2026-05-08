<?php

namespace App\Enums;

class OrderItemStatus
{
    public const PENDING = 'pending';
    public const INPROGRESS = 'inprogress';
    public const DELIVERED = 'delivered';
    public const CANCELLED = 'cancelled';
    public const READYTODILIVER = 'ready-to-deliver';

    public static function all(): array
    {
        return [
            self::PENDING,
            self::INPROGRESS,
            self::DELIVERED,
            self::CANCELLED,
            self::READYTODILIVER
        ];
    }
}
