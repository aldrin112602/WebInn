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
        Schema::create('highest_possible_score_grading_sheets', function (Blueprint $table) {
            $table->id();

            // Added new fields
            $table->integer('grade_handle_id')->nullable();
            


            // For Written Work
            $table->integer('highest_possible_written_1')->nullable();
            $table->integer('highest_possible_written_2')->nullable();
            $table->integer('highest_possible_written_3')->nullable();
            $table->integer('highest_possible_written_4')->nullable();
            $table->integer('highest_possible_written_5')->nullable();
            $table->integer('highest_possible_written_6')->nullable();
            $table->integer('highest_possible_written_7')->nullable();
            $table->integer('highest_possible_written_8')->nullable();
            $table->integer('highest_possible_written_9')->nullable();
            $table->integer('highest_possible_written_10')->nullable();

            // For Performance Task
            $table->integer('highest_possible_task_1')->nullable();
            $table->integer('highest_possible_task_2')->nullable();
            $table->integer('highest_possible_task_3')->nullable();
            $table->integer('highest_possible_task_4')->nullable();
            $table->integer('highest_possible_task_5')->nullable();
            $table->integer('highest_possible_task_6')->nullable();
            $table->integer('highest_possible_task_7')->nullable();
            $table->integer('highest_possible_task_8')->nullable();
            $table->integer('highest_possible_task_9')->nullable();
            $table->integer('highest_possible_task_10')->nullable();

            $table->integer('teacher_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('highest_possible_score_grading_sheets');
    }
};
