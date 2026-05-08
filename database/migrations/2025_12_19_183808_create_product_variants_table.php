<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->index();
            $table->foreignId('color_id')->index();
            $table->foreignId('size_id')->index();

            $table->decimal('price', 10, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->timestamps();

            $table->unique(['product_id', 'color_id', 'size_id']);

            $table->foreign('product_id', 'fk_product_variants_product')
                  ->references('id')->on('products')
                  ->cascadeOnDelete();

            $table->foreign('color_id', 'fk_product_variants_color')
                  ->references('id')->on('colors')
                  ->cascadeOnDelete();

            $table->foreign('size_id', 'fk_product_variants_size')
                  ->references('id')->on('sizes')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};

