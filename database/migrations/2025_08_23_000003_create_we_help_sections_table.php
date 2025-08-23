<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('we_help_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body')->nullable();
            $table->string('grid_image_1')->nullable();
            $table->string('grid_image_2')->nullable();
            $table->string('grid_image_3')->nullable();
            $table->json('list_items')->nullable();
            $table->string('button_text')->nullable();
            $table->enum('button_type', ['internal','external'])->default('internal');
            $table->foreignId('button_page_id')->nullable()->constrained('pages')->nullOnDelete();
            $table->string('button_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('we_help_sections');
    }
};

