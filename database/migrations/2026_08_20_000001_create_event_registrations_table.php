<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('registration_number')->unique(); // ARI-2026-XXXX
            $table->string('full_name');
            $table->string('email');
            $table->string('phone', 20);
            $table->enum('type', ['client', 'non_client'])->default('non_client');
            $table->enum('status', ['pending', 'otp_verified', 'kyc_completed', 'payment_pending', 'paid', 'confirmed', 'checked_in'])->default('pending');
            $table->string('referral_code', 12)->unique()->nullable();
            $table->string('referred_by', 12)->nullable()->index();
            $table->timestamp('otp_verified_at')->nullable();
            $table->timestamp('kyc_completed_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
    }
};
