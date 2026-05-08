<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('show_areas', function (Blueprint $table) {
            $table->id();

            // Unique machine-readable key (used in code & queries)
            $table->string('key', 50)->unique();

            // Human-readable name
            $table->string('name', 100)->index();

            // Enable / disable area without deleting
            $table->boolean('is_active')->default(true)->index();

            // Ordering for homepage sections
            $table->unsignedSmallInteger('priority')->default(0)->index();

            $table->timestamps();

            // Composite index for common queries
            $table->index(['is_active', 'priority']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('show_areas');
    }
};
