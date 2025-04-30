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
        Schema::create('user_attempts', function (Blueprint $table) {
            $table->id();
            $table->text('user_agent');
            $table->integer('attempts')->default(0);
            $table->boolean('is_restricted')->default(false);
            $table->timestamp('last_attempt_at')->nullable();
            $table->timestamp('restricted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_attempts');
    }
};
