<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop old enum column
            $table->dropColumn('payment_method');
        });

        Schema::table('orders', function (Blueprint $table) {
            // Add new flexible column
            $table->string('payment_method')->default('cod')->after('total_amount');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_method');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_method', ['bank_transfer', 'cod'])->default('cod');
        });
    }
};
