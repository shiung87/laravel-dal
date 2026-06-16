<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sso_settings', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable();
            $table->string('client_id')->nullable();
            $table->text('client_secret')->nullable();   // stored encrypted
            $table->string('redirect_uri')->nullable();  // auto-generated if blank
            $table->boolean('enabled')->default(false);
            $table->timestamps();
        });

        // Seed with one blank row so there's always a record to update
        \Illuminate\Support\Facades\DB::table('sso_settings')->insert([
            'enabled'    => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('sso_settings');
    }
};
