<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('page_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained()->cascadeOnDelete();
            $table->morphs('sectionable'); // sectionable_type, sectionable_id
            $table->string('section_type'); // "hero", "top-products", etc (for convenience)
            $table->string('view_file');    // e.g. "hero" or "top-products" (rendered at resources/views/sections/{view_file}.blade.php)
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();

            $table->index(['page_id', 'sort_order']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('page_sections');
    }
};

