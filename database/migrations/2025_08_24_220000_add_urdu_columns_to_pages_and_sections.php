<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pages
        Schema::table('pages', function (Blueprint $table) {
            $table->string('title_ur')->nullable()->after('title');
            $table->string('meta_title_ur')->nullable()->after('meta_title');
            $table->text('meta_description_ur')->nullable()->after('meta_description');
            $table->string('meta_keywords_ur')->nullable()->after('meta_keywords');
        });

        // Hero Section
        Schema::table('hero_sections', function (Blueprint $table) {
            $table->string('title_ur')->nullable()->after('title');
            $table->text('description_ur')->nullable()->after('description');
            $table->string('primary_button_text_ur')->nullable()->after('primary_button_text');
            $table->string('secondary_button_text_ur')->nullable()->after('secondary_button_text');
        });

        // Top Product Section
        Schema::table('top_product_sections', function (Blueprint $table) {
            $table->string('title_ur')->nullable()->after('title');
            $table->text('body_ur')->nullable()->after('body');
            $table->string('button_text_ur')->nullable()->after('button_text');
        });

        // We Help Section
        Schema::table('we_help_sections', function (Blueprint $table) {
            $table->string('title_ur')->nullable()->after('title');
            $table->text('body_ur')->nullable()->after('body');
            $table->json('list_items_ur')->nullable()->after('list_items');
            $table->string('button_text_ur')->nullable()->after('button_text');
        });

        // Testimonials Section
        Schema::table('testimonial_sections', function (Blueprint $table) {
            $table->string('title_ur')->nullable()->after('title');
            $table->json('testimonials_ur')->nullable()->after('testimonials');
        });

        // Popular Products Section
        Schema::table('popular_products_sections', function (Blueprint $table) {
            $table->string('title_ur')->nullable()->after('title');
        });

        // Why Choose Us Section
        Schema::table('why_choose_us_sections', function (Blueprint $table) {
            $table->string('title_ur')->nullable()->after('title');
            $table->text('body_ur')->nullable()->after('body');
            $table->json('features_ur')->nullable()->after('features');
        });

        // Blog Section
        Schema::table('blog_sections', function (Blueprint $table) {
            $table->string('title_ur')->nullable()->after('title');
            $table->string('view_all_text_ur')->nullable()->after('view_all_text');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['title_ur','meta_title_ur','meta_description_ur','meta_keywords_ur']);
        });

        Schema::table('hero_sections', function (Blueprint $table) {
            $table->dropColumn(['title_ur','description_ur','primary_button_text_ur','secondary_button_text_ur']);
        });

        Schema::table('top_product_sections', function (Blueprint $table) {
            $table->dropColumn(['title_ur','body_ur','button_text_ur']);
        });

        Schema::table('we_help_sections', function (Blueprint $table) {
            $table->dropColumn(['title_ur','body_ur','list_items_ur','button_text_ur']);
        });

        Schema::table('testimonial_sections', function (Blueprint $table) {
            $table->dropColumn(['title_ur','testimonials_ur']);
        });

        Schema::table('popular_products_sections', function (Blueprint $table) {
            $table->dropColumn(['title_ur']);
        });

        Schema::table('why_choose_us_sections', function (Blueprint $table) {
            $table->dropColumn(['title_ur','body_ur','features_ur']);
        });

        Schema::table('blog_sections', function (Blueprint $table) {
            $table->dropColumn(['title_ur','view_all_text_ur']);
        });
    }
};

