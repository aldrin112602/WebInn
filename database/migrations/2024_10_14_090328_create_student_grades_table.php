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
        Schema::create('student_grades', function (Blueprint $table) {
            $table->id();
            $table->integer('teacher_id');
            $table->integer('student_id');

            // newly added column
            $table->unsignedBigInteger('grade_handle_id');
            $table->string('grade')->nullable();
            $table->string('strand')->nullable();
            $table->string('section')->nullable();
            
            // added on 11/30/2024
            $table->string('subject')->nullable();
            $table->string('semester')->nullable();
            $table->string('quarter')->nullable();
            $table->string('track')->nullable();

            

            // For Written Work
            $table->integer('written_1')->nullable();
            $table->integer('written_2')->nullable();
            $table->integer('written_3')->nullable();
            $table->integer('written_4')->nullable();
            $table->integer('written_5')->nullable();
            $table->integer('written_6')->nullable();
            $table->integer('written_7')->nullable();
            $table->integer('written_8')->nullable();
            $table->integer('written_9')->nullable();
            $table->integer('written_10')->nullable();
            $table->integer('written_total')->nullable();
            $table->integer('written_ps')->nullable();
            $table->integer('written_ws')->nullable();

            // For Performance Task
            $table->integer('task_1')->nullable();
            $table->integer('task_2')->nullable();
            $table->integer('task_3')->nullable();
            $table->integer('task_4')->nullable();
            $table->integer('task_5')->nullable();
            $table->integer('task_6')->nullable();
            $table->integer('task_7')->nullable();
            $table->integer('task_8')->nullable();
            $table->integer('task_9')->nullable();
            $table->integer('task_10')->nullable();
            $table->integer('task_total')->nullable();
            $table->integer('task_ps')->nullable();
            $table->integer('task_ws')->nullable();

            // For Quarterly Assessment
            $table->integer('quart_1')->nullable();
            $table->integer('quart_ps')->nullable();
            $table->integer('quart_ws')->nullable();
            $table->double('initial_grade', 8, 2)->nullable();
            $table->integer('quarterly_grade')->nullable();

            $table->timestamps();

            $table->foreign('grade_handle_id')->references('id')->on('teacher_grade_handles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_grades');
    }
};
