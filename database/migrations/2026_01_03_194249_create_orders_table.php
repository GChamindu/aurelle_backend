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
       Schema::create('orders', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // linked if user exists
    $table->string('order_number')->unique()->index(); // unique invoice number

    $table->decimal('subtotal', 10, 2);
    $table->decimal('shipping_cost', 10, 2)->default(0);
    $table->decimal('total_amount', 10, 2);

    $table->enum('payment_method', ['bank_transfer', 'cod'])->default('cod');
    $table->enum('payment_status', ['pending', 'paid', 'failed'])->default('pending');

    $table->enum('order_status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])
          ->default('pending');

    $table->text('note')->nullable();

    $table->timestamps();

    // Optimizations
    $table->index(['order_status', 'payment_status']);
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
