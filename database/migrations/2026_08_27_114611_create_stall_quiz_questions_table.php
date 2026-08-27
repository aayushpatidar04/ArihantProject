<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stall_quiz_questions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('stall_quiz_id')
                ->constrained('stall_quizzes')
                ->cascadeOnDelete();

            $table->text('question');

            $table->unsignedInteger('points')
                ->default(1);

            $table->unsignedInteger('sort_order')
                ->default(0);

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();

            $table->index(['stall_quiz_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stall_quiz_questions');
    }
};