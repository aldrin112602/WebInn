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
        Schema::create('attendance_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_model_id');
            $table->unsignedBigInteger('grade_handle_id');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('student_id');
            $table->string('status');
            $table->string('time_in')->default('N/A')->nullable();
            $table->date('date');
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('student_accounts')->onDelete('cascade');

            $table->foreign('subject_model_id')->references('id')->on('subject_models')->onDelete('cascade');

            $table->foreign('teacher_id')->references('id')->on('teacher_accounts')->onDelete('cascade');
            
            $table->foreign('grade_handle_id')->references('id')->on('teacher_grade_handles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_histories');
    }
};
