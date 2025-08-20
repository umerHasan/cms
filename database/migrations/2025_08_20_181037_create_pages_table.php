<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('pages')->nullOnDelete();
            $table->string('title');
            $table->string('slug');                          // unique among siblings
            $table->string('full_path')->unique();           // computed: e.g. "about/our-group"
            // SEO / meta
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            // Publishing
            $table->boolean('is_published')->default(false)->index();
            $table->timestamp('published_at')->nullable()->index();
            // Auditing (optional)
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['parent_id', 'slug']);
            $table->index('parent_id');
        });
    }

    public function down(): void {
        Schema::dropIfExists('pages');
    }
};

