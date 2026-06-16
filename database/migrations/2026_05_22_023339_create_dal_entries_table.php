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
        Schema::create('dal_entries', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['capital', 'noncapital'])->default('capital');
            $table->string('section_title');
            $table->integer('row_number');
            $table->string('malaysia')->nullable();
            $table->string('singapore')->nullable();
            $table->string('australia')->nullable();
            $table->string('vietnam')->nullable();
            $table->string('japan')->nullable();
            $table->string('shr')->nullable();
            $table->string('sub_shr')->nullable();
            $table->string('bod')->nullable();
            $table->string('sub_bod')->nullable();
            $table->string('nrc')->nullable();
            $table->string('ac')->nullable();
            $table->string('rmc')->nullable();
            $table->string('tpc')->nullable();
            $table->string('fic')->nullable();
            $table->string('sc')->nullable();
            $table->string('sub_exco')->nullable();
            $table->string('ceo')->nullable();
            $table->string('deputy_ceo_coo')->nullable();
            $table->string('sevp')->nullable();
            $table->string('evp')->nullable();
            $table->string('dgm')->nullable();
            $table->string('gm')->nullable();
            $table->string('deputy_gm_head')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dal_entries');
    }
};
