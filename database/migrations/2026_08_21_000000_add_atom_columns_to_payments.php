<?php
// database/migrations/2026_08_21_000000_add_atom_columns_to_payments.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->string('merch_txn_id')->nullable()->after('gateway_order_id')->index();
            $table->string('atom_token_id')->nullable()->after('merch_txn_id');
        });
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['merch_txn_id', 'atom_token_id']);
        });
    }
};