<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blog_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('view_all_text')->nullable();
            $table->enum('view_all_type', ['internal','external'])->default('external');
            $table->foreignId('view_all_page_id')->nullable()->constrained('pages')->nullOnDelete();
            $table->string('view_all_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_sections');
    }
};

