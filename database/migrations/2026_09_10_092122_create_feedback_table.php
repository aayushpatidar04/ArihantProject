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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('phone', 10)->unique();
            $table->string('city');
            // Q1
            $table->unsignedTinyInteger('experience_rating')->nullable();
            // Q2
            $table->string('session_quality')->nullable();
            // Q3
            $table->string('content_usefulness')->nullable();
            // Q4
            $table->string('networking_rating')->nullable();
            // Q5
            $table->text('most_valuable_session')->nullable();
            // Q6
            $table->text('liked_most')->nullable();
            // Q7
            $table->text('improvements')->nullable();
            // Q8
            $table->string('recommendation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
