<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stall_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_registration_id')->constrained()->onDelete('cascade');
            $table->foreignId('stall_id')->constrained()->onDelete('cascade');
            $table->timestamp('visited_at');
            $table->tinyInteger('rating')->nullable(); // 1-5
            $table->text('feedback')->nullable();
            $table->json('quiz_answers')->nullable();
            $table->tinyInteger('quiz_score')->nullable();
            $table->integer('engagement_points')->default(10);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stall_visits');
    }
};
