<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_id')->constrained('event_registrations')->onDelete('cascade');
            $table->foreignId('referred_id')->nullable()->constrained('event_registrations')->onDelete('set null');
            $table->string('referred_email');
            $table->string('referred_phone', 20)->nullable();
            $table->enum('status', ['invited', 'registered', 'paid'])->default('invited');
            $table->integer('points_awarded')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
