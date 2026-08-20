<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            // Add city column
            $table->string('city', 100)->nullable()->after('phone');
            // Change type enum from client/non_client to investor/trader
            $table->enum('type', ['investor', 'trader'])->default('investor')->change();
        });
    }

    public function down(): void
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            $table->dropColumn('city');
            $table->enum('type', ['client', 'non_client'])->default('non_client')->change();
        });
    }
};
