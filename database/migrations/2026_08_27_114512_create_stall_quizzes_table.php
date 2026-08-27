<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stall_quizzes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('stall_id')
                ->constrained('stalls')
                ->cascadeOnDelete();

            $table->string('title');
            $table->text('description')->nullable();

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();

            $table->index(['stall_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stall_quizzes');
    }
};