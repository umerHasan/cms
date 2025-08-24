<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('name_ur')->nullable()->after('name');
            $table->text('description_ur')->nullable()->after('description');
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->string('title_ur')->nullable()->after('title');
            $table->string('author_name_ur')->nullable()->after('author_name');
            $table->string('excerpt_ur')->nullable()->after('excerpt');
            $table->longText('body_ur')->nullable()->after('body');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['name_ur','description_ur']);
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['title_ur','author_name_ur','excerpt_ur','body_ur']);
        });
    }
};

