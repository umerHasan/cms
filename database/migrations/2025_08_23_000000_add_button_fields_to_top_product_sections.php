<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('top_product_sections', function (Blueprint $table) {
            $table->string('button_text')->nullable()->after('body');
            $table->string('button_type')->nullable()->after('button_text');
            $table->foreignId('button_page_id')->nullable()->after('button_type')->constrained('pages')->nullOnDelete();
            $table->string('button_url')->nullable()->after('button_page_id');
        });
    }

    public function down(): void
    {
        Schema::table('top_product_sections', function (Blueprint $table) {
            $table->dropConstrainedForeignId('button_page_id');
            $table->dropColumn(['button_text','button_type','button_url']);
        });
    }
};

