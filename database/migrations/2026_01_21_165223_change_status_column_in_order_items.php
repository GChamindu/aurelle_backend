<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Change ENUM → VARCHAR to allow new/flexible statuses
            $table->string('order_status', 30)
                  ->default('pending')
                  ->change();

            // Add an index for faster queries by status
            $table->index('order_status');

            // Optional: composite index for frequent queries (e.g., status + payment_status)
            $table->index(['order_status', 'order_number']);
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Rollback column type
            $table->enum('order_status', [
                'pending',
                'processing',
                'shipped',
                'delivered',
                'cancelled'
            ])->default('pending')
              ->change();

            // Drop the indexes
            $table->dropIndex(['order_status']);
            $table->dropIndex(['order_status', 'payment_status']);
        });
    }
};
