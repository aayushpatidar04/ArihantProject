<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lead_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_registration_id')->constrained()->onDelete('cascade');
            $table->integer('registration_score')->default(10);
            $table->integer('kyc_score')->default(0);
            $table->integer('quiz_score')->default(0);
            $table->integer('stall_visit_score')->default(0);
            $table->integer('referral_score')->default(0);
            $table->integer('social_score')->default(0);
            $table->integer('total_score')->default(10);
            $table->boolean('synced_to_crm')->default(false);
            $table->timestamp('synced_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lead_scores');
    }
};
