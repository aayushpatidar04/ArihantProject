<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            $table->boolean('promo_code_used')
                ->default(false)
                ->after('status');

            $table->string('promo_code', 50)
                ->nullable()
                ->after('promo_code_used');

            $table->unsignedInteger('promo_amount')
                ->nullable()
                ->after('promo_code');
        });
    }

    public function down(): void
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            $table->dropColumn([
                'promo_code_used',
                'promo_code',
                'promo_amount',
            ]);
        });
    }
};