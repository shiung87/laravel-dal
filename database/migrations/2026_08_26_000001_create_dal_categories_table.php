<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dal_categories', function (Blueprint $table) {
            $table->id();
            $table->string('code', 30);                // e.g. '1.0', '2.0', '4.0 - 6.0'
            $table->string('slug', 60)->unique();       // e.g. 'corporate_matter', 'finance'
            $table->string('name', 100);               // e.g. 'Corporate Matter'
            $table->string('full_title', 150);         // e.g. '1.0 Corporate Matter'
            $table->string('short_title', 100);        // e.g. '1.0 Corporate'
            $table->string('badge_color', 30)->default('blue');
            $table->string('icon', 50)->default('folder');
            $table->text('description')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dal_categories');
    }
};
