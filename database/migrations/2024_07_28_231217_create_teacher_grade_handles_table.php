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
        Schema::create('teacher_grade_handles', function (Blueprint $table) {
            $table->id();
            $table->string('grade')->nullable();
            $table->string('strand')->nullable();
            $table->string('section')->nullable();

            // newly added columns
            $table->string('semester')->nullable()->default('First semester');
            $table->string('quarter')->nullable()->default('First quarter');
            $table->string('subject')->nullable();
            $table->string('track')->nullable();

            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->timestamps();

            // Add the foreign key constraint
            $table->foreign('teacher_id')->references('id')->on('teacher_accounts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_grade_handles');
    }
};
