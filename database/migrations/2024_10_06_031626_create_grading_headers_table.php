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
        Schema::create('grading_headers', function (Blueprint $table) {
            $table->id();
            $table->integer('teacher_id')->nullable();
            $table->string('region')->default('IV - A')->nullable();
            $table->string('division')->default('2nd')->nullable();
            $table->string('school_name')->default('Philippine Technological Institute of Science Arts and Trade Inc')->nullable();
            $table->string('school_id')->default('405210')->nullable();
            $table->string('school_year')->default('2023-2024')->nullable();
            
            // Added new fields
            $table->integer('grade_handle_id')->nullable();

            $table->string('written_work_percentage')->nullable();
            $table->string('performance_task_percentage')->nullable();
            $table->string('quarterly_assessment_percentage')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grading_headers');
    }
};
