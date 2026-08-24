<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('email_settings', function (Blueprint $table) {
            $table->id();
            $table->string('mailer')->default('smtp'); // smtp, log, sendmail, etc.
            $table->string('host')->nullable();
            $table->integer('port')->default(587);
            $table->string('username')->nullable();
            $table->text('password')->nullable(); // encrypted
            $table->string('encryption')->nullable()->default('tls'); // tls, ssl, null
            $table->string('from_address')->nullable();
            $table->string('from_name')->nullable();
            $table->boolean('notifications_enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_settings');
    }
};
