<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('user_name')->nullable();  // snapshot in case user is later deleted
            $table->string('user_email')->nullable();
            $table->string('action', 80);             // e.g. login, dal_create, user_promote
            $table->string('subject_type', 80)->nullable(); // e.g. DalEntry, User
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('subject_label')->nullable(); // human-readable identifier
            $table->json('old_values')->nullable();   // field values before change
            $table->json('new_values')->nullable();   // field values after change
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['action', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index(['subject_type', 'subject_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
