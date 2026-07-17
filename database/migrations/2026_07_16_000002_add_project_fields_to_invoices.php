<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Project-invoice fields for the approved invoice layout: the project name,
 * the payment/installment label (e.g. "الدفعة الأولى (40%)"), and a themeable
 * accent colour.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('project_name')->nullable()->after('exhibition_id');
            $table->string('payment_type')->nullable()->after('project_name');
            $table->string('accent_color')->default('#173B63')->after('payment_type');
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn(['project_name', 'payment_type', 'accent_color']);
        });
    }
};
