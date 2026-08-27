<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stall_visit_quiz_answers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('stall_visit_id')
                ->constrained('stall_visits')
                ->cascadeOnDelete();

            $table->foreignId('stall_quiz_question_id')
                ->constrained('stall_quiz_questions')
                ->cascadeOnDelete();

            $table->foreignId('stall_quiz_option_id')
                ->constrained('stall_quiz_options')
                ->cascadeOnDelete();

            $table->boolean('is_correct')
                ->default(false);

            $table->unsignedInteger('points_earned')
                ->default(0);

            $table->timestamps();

            $table->unique(
                ['stall_visit_id', 'stall_quiz_question_id'],
                'stall_visit_question_unique'
            );

            $table->index('stall_quiz_option_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stall_visit_quiz_answers');
    }
};