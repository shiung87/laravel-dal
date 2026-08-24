<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('dal_entries', function (Blueprint $table) {
            $table->string('category', 50)->default('finance')->after('id');
            $table->string('type', 50)->nullable()->change();
        });

        // Ensure all existing records are assigned to the 'finance' category
        DB::table('dal_entries')
            ->whereNull('category')
            ->orWhere('category', '')
            ->update(['category' => 'finance']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dal_entries', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
