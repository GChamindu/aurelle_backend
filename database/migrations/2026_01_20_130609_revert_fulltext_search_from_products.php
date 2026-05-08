<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * PRODUCTS
         */
        try {
            DB::statement('ALTER TABLE products DROP INDEX ft_products_search');
        } catch (\Throwable $e) {}

        if (Schema::hasColumn('products', 'keywords_text')) {
            try {
                DB::statement('ALTER TABLE products DROP COLUMN keywords_text');
            } catch (\Throwable $e) {}
        }

        /**
         * CATEGORIES
         */
        try {
            DB::statement('ALTER TABLE categories DROP INDEX ft_categories_name');
        } catch (\Throwable $e) {}

        /**
         * COLLECTIONS
         */
        try {
            DB::statement('ALTER TABLE collections DROP INDEX ft_collections_name');
        } catch (\Throwable $e) {}
    }

    public function down(): void
    {
        // Optional: you can re-add indexes here if ever needed
    }
};
