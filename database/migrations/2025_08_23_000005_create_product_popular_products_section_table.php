<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('product_popular_products_section', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            // Define FK with a short, explicit name to stay under MySQL's 64-char limit
            $table->foreignId('popular_products_section_id');
            $table->foreign('popular_products_section_id', 'ppps_section_id_fk')
                ->references('id')
                ->on('popular_products_sections')
                ->cascadeOnDelete();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('product_popular_products_section');
    }
};
