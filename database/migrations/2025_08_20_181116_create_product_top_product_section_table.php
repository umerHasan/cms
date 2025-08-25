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
            // Use a short, explicit name to avoid MySQL's 64-char index name limit
            $table->unique(['top_product_section_id','product_id'], 'ptps_section_product_unique');
        });
    }
    public function down(): void {
        Schema::dropIfExists('product_top_product_section');
    }
};
