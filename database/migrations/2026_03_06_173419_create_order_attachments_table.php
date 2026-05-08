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
        Schema::create('order_attachments', function (Blueprint $table) {
            $table->id();

            // FIX: Place constrained() before index(), or remove index() as constrained() usually creates it.
            $table->foreignId('order_id')
                ->constrained()
                ->cascadeOnDelete();

            // File info
            $table->string('file_name', 255);
            $table->string('file_path', 500);

            // Security / integrity
            $table->char('file_hash', 64)->unique();

            // Metadata
            $table->string('mime_type', 100)->index();
            $table->unsignedBigInteger('file_size');

            $table->timestamps();

            // Composite indexes
            $table->index(['order_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_attachments');
    }
};
