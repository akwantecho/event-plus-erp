<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Price quotations (عرض سعر) — the company's approved quote layout:
 * a cover, a timeline + costs sheet, and a notices sheet.
 *
 * The billable cost rows live in quotation_items (each carries a numeric
 * total). Free-text timeline rows and notice paragraphs are stored as JSON
 * on the quotation itself — mirroring how invoices keep timeline/scope JSON.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->foreignId('client_id')->nullable()->constrained('contacts')->nullOnDelete();
            $table->foreignId('exhibition_id')->nullable()->constrained()->nullOnDelete();
            $table->string('project_name')->nullable();   // اسم المشروع
            $table->string('recipient')->nullable();       // المرسل إلى (اسم الجهة)
            $table->string('currency')->default('ر.ع');
            $table->date('issue_date')->nullable();
            $table->date('event_from')->nullable();        // تاريخ المعرض — من
            $table->date('event_to')->nullable();          // تاريخ المعرض — إلى
            $table->string('accent_color')->default('#173B63');
            $table->json('timeline')->nullable();          // [{item, duration}]
            $table->json('notices')->nullable();           // [{title, body}]
            $table->decimal('grand_total', 15, 2)->default(0);
            $table->string('status')->default('Draft');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quotation_id')->constrained()->cascadeOnDelete();
            $table->string('description')->nullable();     // البند
            $table->string('qty_label')->nullable();       // الكمية / العدد (نص حر: "10 أيام"، "5 أشخاص")
            $table->string('price_label')->nullable();     // السعر (نص حر: "150 ر.ع / لليوم")
            $table->decimal('total', 15, 2)->default(0);   // الإجمالي (رقمي)
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotation_items');
        Schema::dropIfExists('quotations');
    }
};
