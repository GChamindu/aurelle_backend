<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_search_indexes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->unique()
                ->constrained()
                ->cascadeOnDelete();

            $table->longText('search_text');

            $table->timestamps();
        });

        DB::statement('ALTER TABLE product_search_indexes ENGINE=InnoDB');

        DB::statement('
            ALTER TABLE product_search_indexes
            ADD FULLTEXT INDEX ft_product_search (search_text)
        ');
    }

    public function down(): void
    {
        Schema::dropIfExists('product_search_indexes');
    }
};
