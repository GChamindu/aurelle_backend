<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('category_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->timestamps();

            $table->unique(['product_id', 'category_id']);
        });

        /**
         * -------------------------------------------------
         * MOVE EXISTING DATA (SAFE COPY)
         * -------------------------------------------------
         * This copies current products.category_id
         * into the new pivot table.
         */
        DB::table('products')
            ->whereNotNull('category_id')
            ->select('id', 'category_id')
            ->chunkById(500, function ($products) {
                $data = [];

                foreach ($products as $product) {
                    $data[] = [
                        'product_id' => $product->id,
                        'category_id' => $product->category_id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if (!empty($data)) {
                    DB::table('category_product')->insertOrIgnore($data);
                }
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_product');
    }
};
