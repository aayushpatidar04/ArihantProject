<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('finbridge_registrations', function (Blueprint $table) {
            $table->string('interest')->nullable()->after('type');          // investing, trading, both, exploring
            $table->boolean('has_demat')->nullable()->after('interest');
            $table->string('invest_frequency')->nullable()->after('has_demat'); // regularly, occasionally, planning_to_start, dont_invest
            $table->string('start_timeline')->nullable()->after('invest_frequency'); // immediately, within_1_month, within_3_months, not_sure
            $table->json('products')->nullable()->after('start_timeline');  // ["stocks","mutual_funds",...]

            $table->unsignedSmallInteger('lead_score')->default(0)->after('products');
            $table->string('lead_status')->default('cold')->index()->after('lead_score'); // hot, warm, cold
        });
    }

    public function down(): void
    {
        Schema::table('finbridge_registrations', function (Blueprint $table) {
            $table->dropIndex(['lead_status']);
            $table->dropColumn([
                'interest', 'has_demat', 'invest_frequency',
                'start_timeline', 'products', 'lead_score', 'lead_status'
            ]);
        });
    }
};