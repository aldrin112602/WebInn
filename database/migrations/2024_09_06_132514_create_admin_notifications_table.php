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
        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('title')->nullable();
            $table->text('message');
            $table->boolean('is_seen')->default(false);
            $table->string('url')->nullable();
            $table->string('icon')->nullable();
            $table->enum('priority', ['low', 'medium', 'high'])->default('low');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('admin_accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
    }
};
