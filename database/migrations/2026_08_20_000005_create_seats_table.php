<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seats', function (Blueprint $table) {
            $table->id();
            $table->string('seat_number', 20)->unique();
            $table->string('section', 20)->nullable(); // A, B, VIP
            $table->string('row', 10)->nullable();
            $table->enum('status', ['available', 'allocated', 'blocked'])->default('available');
            $table->foreignId('event_registration_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('allocated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
