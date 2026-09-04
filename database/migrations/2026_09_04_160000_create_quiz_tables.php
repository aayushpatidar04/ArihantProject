<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('quiz_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('quiz_type', 50);
            $table->string('pin', 6);
            $table->enum('status', ['waiting', 'active', 'paused', 'completed'])->default('waiting');
            $table->unsignedInteger('current_question_order')->default(0);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();

            $table->unique('pin');
            $table->index('quiz_type');
            $table->index('status');
        });

        Schema::create('quiz_questions', function (Blueprint $table) {
            $table->id();
            $table->string('quiz_type', 50);
            $table->text('question_text');
            $table->json('options');
            $table->tinyInteger('correct_option');
            $table->unsignedInteger('order');
            $table->unsignedInteger('time_limit')->nullable();
            $table->timestamps();

            $table->index(['quiz_type', 'order']);
            $table->index('quiz_type');
        });

        Schema::create('quiz_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('quiz_sessions')->onDelete('cascade');
            $table->string('name');
            $table->string('email');
            $table->string('mobile');
            $table->timestamp('joined_at');
            $table->timestamps();

            $table->unique(['session_id', 'email']);
            $table->index('session_id');
        });

        Schema::create('quiz_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained('quiz_sessions')->onDelete('cascade');
            $table->foreignId('participant_id')->constrained('quiz_participants')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('quiz_questions')->onDelete('cascade');
            $table->tinyInteger('selected_option');
            $table->boolean('is_correct');
            $table->unsignedInteger('response_time_ms')->nullable();
            $table->timestamp('submitted_at');

            $table->unique(['session_id', 'participant_id', 'question_id']);
            $table->index(['session_id', 'question_id']);
            $table->index(['session_id', 'participant_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_answers');
        Schema::dropIfExists('quiz_participants');
        Schema::dropIfExists('quiz_questions');
        Schema::dropIfExists('quiz_sessions');
    }
};
