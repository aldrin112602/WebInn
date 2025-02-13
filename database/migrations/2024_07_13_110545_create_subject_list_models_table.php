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
        Schema::create('subject_models', function (Blueprint $table) {
            $table->id();
            $table->string('subject')->nullable();
            $table->string('subject_track')->nullable();
            $table->string('day')->nullable();
            $table->unsignedBigInteger('grade_handle_id')->nullable();
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->string('time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_models');
    }
};
