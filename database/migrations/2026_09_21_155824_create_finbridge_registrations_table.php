<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('finbridge_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('registration_number')->unique(); // ARI-2026-XXXX
            $table->string('full_name');
            $table->string('email');
            $table->string('phone', 10);
            $table->string('city');
            $table->enum('type', ['investor', 'trader'])->default('trader');
            $table->enum('status', ['pending', 'confirmed'])->default('pending');
            $table->timestamp('otp_verified_at')->nullable();
            $table->timestamp('kyc_completed_at')->nullable();
            $table->boolean('is_existing_client')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finbridge_registrations');
    }
};
