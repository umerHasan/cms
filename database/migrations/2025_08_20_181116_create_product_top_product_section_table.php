<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('product_top_product_section', function (Blueprint $table) {
            $table->id();
            $table->foreignId('top_product_section_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();
            $table->unique(['top_product_section_id','product_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('product_top_product_section');
    }
};
