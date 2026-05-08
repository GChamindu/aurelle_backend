<?php

namespace App\Enums;

enum ProductImageType: int
{
    case DEFAULT_MAIN   = 1;
    case DEFAULT_HOVER  = 2;
    case VARIANT_MAIN   = 3;
    case GALLERY        = 4;

    public function label(): string
    {
        return match ($this) {
            self::DEFAULT_MAIN  => 'default_main',
            self::DEFAULT_HOVER => 'default_hover',
            self::VARIANT_MAIN  => 'variant_main',
            self::GALLERY       => 'gallery',
        };
    }
}
