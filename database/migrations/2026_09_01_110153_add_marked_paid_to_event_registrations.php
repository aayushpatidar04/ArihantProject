<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            $table->foreignId('marked_paid_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('marked_paid_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            $table->dropForeign(['marked_paid_by']);
            $table->dropColumn(['marked_paid_by', 'marked_paid_at']);
        });
    }
};