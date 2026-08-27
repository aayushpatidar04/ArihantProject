<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stall_quiz_options', function (Blueprint $table) {
            $table->id();

            $table->foreignId('stall_quiz_question_id')
                ->constrained('stall_quiz_questions')
                ->cascadeOnDelete();

            $table->text('option_text');

            $table->boolean('is_correct')
                ->default(false);

            $table->unsignedInteger('sort_order')
                ->default(0);

            $table->timestamps();

            $table->index('stall_quiz_question_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stall_quiz_options');
    }
};