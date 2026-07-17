<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Quotation workflow: what kind of work the quote targets (exhibition or
 * project) and the payment plan agreed on approval. On approval the target
 * entity is created and one invoice is generated per installment.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->string('target_type')->default('exhibition')->after('exhibition_id'); // exhibition | project
            $table->json('installments')->nullable()->after('notices');                    // [{label, percent, due_date}]
            $table->timestamp('approved_at')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('quotations', function (Blueprint $table) {
            $table->dropColumn(['target_type', 'installments', 'approved_at']);
        });
    }
};
