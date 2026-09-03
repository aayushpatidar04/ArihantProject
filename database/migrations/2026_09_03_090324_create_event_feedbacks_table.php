<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_feedbacks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_registration_id')
                ->constrained('event_registrations')
                ->cascadeOnDelete();

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

            $table->unique('event_registration_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_feedbacks');
    }
};