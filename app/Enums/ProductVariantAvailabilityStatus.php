<?php

namespace App\Enums;

enum ProductVariantAvailabilityStatus: int
{
    case AVAILABLE   = 1;
    case SOLD_OUT    = 2;
    case UNAVAILABLE = 3;

    public function label(): string
    {
        return match ($this) {
            self::AVAILABLE   => 'Available',
            self::SOLD_OUT    => 'Sold Out',
            self::UNAVAILABLE => 'Unavailable',
        };
    }
}
