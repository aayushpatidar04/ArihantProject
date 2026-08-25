<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('referrals', function (Blueprint $table) {
            $table->unique('referred_email', 'referrals_referred_email_unique');
            $table->unique('referred_phone', 'referrals_referred_phone_unique');
        });
    }

    public function down(): void
    {
        Schema::table('referrals', function (Blueprint $table) {
            $table->dropUnique('referrals_referred_email_unique');
            $table->dropUnique('referrals_referred_phone_unique');
        });
    }
};