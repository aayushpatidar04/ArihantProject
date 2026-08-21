<?php
// database/migrations/2026_08_21_100000_drop_extra_kyc_columns.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('kyc_details', function (Blueprint $table) {
            $table->dropColumn([
                'pan_number',
                'aadhaar_number',
                'address',
                'city',
                'state',
                'pincode',
                'income_proof_type',
                'income_proof_path',
                'photo_path',
                'signature_path',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('kyc_details', function (Blueprint $table) {
            $table->string('pan_number')->nullable();
            $table->string('aadhaar_number')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('pincode')->nullable();
            $table->string('income_proof_type')->nullable();
            $table->string('income_proof_path')->nullable();
            $table->string('photo_path')->nullable();
            $table->string('signature_path')->nullable();
        });
    }
};