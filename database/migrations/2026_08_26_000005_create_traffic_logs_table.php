<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('traffic_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('user_name')->nullable();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->string('department_name')->nullable();
            $table->string('path', 255);
            $table->string('category_slug', 80)->nullable();
            $table->string('search_query', 255)->nullable();
            $table->string('country_filter', 20)->nullable();
            $table->string('approver_filter', 30)->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('device', 30)->default('desktop');
            $table->timestamp('created_at')->useCurrent();

            $table->index(['created_at']);
            $table->index(['category_slug', 'created_at']);
            $table->index(['department_id', 'created_at']);
            $table->index(['user_id', 'created_at']);
            $table->index(['device', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('traffic_logs');
    }
};
