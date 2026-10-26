<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('quiz_sessions', function (Blueprint $table) {
            // lobby | question | reveal | scoreboard | podium
            $table->string('phase', 20)->default('lobby')->after('status');
            // Millisecond-precision timing (timestamp columns drop milliseconds)
            $table->unsignedBigInteger('question_opens_at_ms')->nullable()->after('question_started_at');
            $table->unsignedBigInteger('question_ends_at_ms')->nullable()->after('question_opens_at_ms');
            $table->unsignedInteger('paused_remaining_ms')->nullable()->after('question_ends_at_ms');
        });

        Schema::table('quiz_answers', function (Blueprint $table) {
            $table->unsignedInteger('points')->default(0)->after('is_correct');
        });
    }

    public function down(): void
    {
        Schema::table('quiz_answers', function (Blueprint $table) {
            $table->dropColumn('points');
        });
        Schema::table('quiz_sessions', function (Blueprint $table) {
            $table->dropColumn(['phase', 'question_opens_at_ms', 'question_ends_at_ms', 'paused_remaining_ms']);
        });
    }
};
