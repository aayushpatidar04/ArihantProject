<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stall_visit_feedback', function (Blueprint $table) {
            $table->id();

            $table->foreignId('stall_visit_id')
                ->constrained('stall_visits')
                ->cascadeOnDelete();

            $table->foreignId('stall_feedback_question_id')
                ->constrained('stall_feedback_questions')
                ->cascadeOnDelete();

            $table->text('answer')->nullable();

            $table->timestamps();

            $table->unique(
                ['stall_visit_id', 'stall_feedback_question_id'],
                'stall_visit_feedback_unique'
            );

            $table->index('stall_feedback_question_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stall_visit_feedback');
    }
};