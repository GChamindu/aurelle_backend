<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{

    protected $fillable = ['name'];
    public function getDisplayNameAttribute()
    {
        $name = trim($this->name);

        // Optional: Add more formatting rules if needed
        if (str_starts_with($name, 'UK ')) {
            return $name; // already good
        }

        if (in_array($name, ['XS','S','M','L','XL','XXL'])) {
            return $name; // letter sizes are fine
        }

        return $name; // fallback
    }

    /**
     * Sort sizes in a human-friendly order
     */
    public static function getSorted()
    {
        return self::orderByRaw("
            CASE
                WHEN name REGEXP '^UK [0-9]+$' THEN CAST(SUBSTRING(name, 4) AS UNSIGNED)
                WHEN name IN ('XS','S','M','L','XL','XXL') THEN FIELD(name, 'XS','S','M','L','XL','XXL')
                ELSE 9999
            END ASC,
            name ASC
        ")->get();
    }
}
