<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('hero_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();

            // Primary button
            $table->string('primary_button_text')->nullable();
            $table->enum('primary_button_type', ['internal','external'])->default('internal');
            $table->foreignId('primary_button_page_id')->nullable()->constrained('pages')->nullOnDelete();
            $table->string('primary_button_url')->nullable();

            // Secondary button
            $table->string('secondary_button_text')->nullable();
            $table->enum('secondary_button_type', ['internal','external'])->default('internal');
            $table->foreignId('secondary_button_page_id')->nullable()->constrained('pages')->nullOnDelete();
            $table->string('secondary_button_url')->nullable();

            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('hero_sections');
    }
};

