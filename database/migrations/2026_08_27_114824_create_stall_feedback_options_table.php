<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stall_feedback_options', function (Blueprint $table) {
            $table->id();

            $table->foreignId('stall_feedback_question_id')
                ->constrained('stall_feedback_questions')
                ->cascadeOnDelete();

            $table->text('option_text');

            $table->unsignedInteger('sort_order')
                ->default(0);

            $table->timestamps();

            $table->index('stall_feedback_question_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stall_feedback_options');
    }
};