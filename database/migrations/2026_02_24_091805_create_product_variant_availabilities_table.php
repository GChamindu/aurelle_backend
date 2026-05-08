<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\ProductVariantAvailabilityStatus;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('product_variant_availabilities', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('color_id')->constrained('colors')->cascadeOnDelete();
            $table->foreignId('size_id')->constrained()->cascadeOnDelete();

            $table->unsignedTinyInteger('status')
                  ->default(ProductVariantAvailabilityStatus::AVAILABLE->value)
                  ->comment('1=available, 2=sold_out, 3=unavailable');

            $table->timestamps();

            $table->unique(
                ['product_id', 'color_id', 'size_id'],
                'product_color_size_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variant_availabilities');
    }
};
