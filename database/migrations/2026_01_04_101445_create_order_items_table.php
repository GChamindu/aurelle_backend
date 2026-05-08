<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // Order reference
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();

            // Product reference (nullable in case product is deleted)
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();

            $table->foreignId('color_id')->nullable()->constrained('colors')->nullOnDelete();
            $table->foreignId('size_id')->nullable()->constrained('sizes')->nullOnDelete();

            // Snapshot data in case product is deleted later
            $table->string('title');
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(1);

            $table->timestamps();

            // Indexes for faster queries
            $table->index(['order_id', 'product_id', 'color_id', 'size_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
