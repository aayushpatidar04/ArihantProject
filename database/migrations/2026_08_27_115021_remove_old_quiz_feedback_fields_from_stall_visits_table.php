<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stall_visits', function (Blueprint $table) {
            $table->dropColumn([
                'rating',
                'feedback',
                'quiz_answers',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('stall_visits', function (Blueprint $table) {
            $table->unsignedInteger('rating')->nullable();
            $table->text('feedback')->nullable();
            $table->text('quiz_answers')->nullable();
        });
    }
};