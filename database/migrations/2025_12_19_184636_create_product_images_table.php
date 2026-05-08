<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Schema::create('product_images', function (Blueprint $table) {
        //     $table->id();

        //     $table->foreignId('product_id')->index();
        //     $table->foreignId('color_id')->nullable()->index();

        //     $table->string('image_path');
        //     $table->boolean('is_primary')->default(false)->index();
        //     $table->timestamps();

        //     $table->unique(['product_id', 'color_id', 'image_path']);

        //     $table->foreign('product_id', 'fk_product_images_product')
        //         ->references('id')->on('products')
        //         ->cascadeOnDelete();

        //     $table->foreign('color_id', 'fk_product_images_color')
        //         ->references('id')->on('colors')
        //         ->nullOnDelete();
        // });


        Schema::create('product_images', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->index();
            $table->foreignId('color_id')->nullable()->index();

            $table->string('image_path');

            $table->unsignedTinyInteger('image_type')->index();

            $table->timestamps();

            $table->unique(['product_id', 'color_id', 'image_path']);

            $table->foreign('product_id', 'fk_product_images_product')
                ->references('id')->on('products')
                ->cascadeOnDelete();

            $table->foreign('color_id', 'fk_product_images_color')
                ->references('id')->on('colors')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
