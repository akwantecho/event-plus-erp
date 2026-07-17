<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Projects — a document context parallel to exhibitions. A project can own
 * contracts, quotations and invoices (linked via project_id on each). This
 * lets project quotations stay separate from exhibition quotations.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('client_id')->nullable()->constrained('contacts')->nullOnDelete();
            $table->string('location')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('status')->default('Upcoming');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        foreach (['quotations', 'invoices', 'contracts'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->foreignId('project_id')->nullable()->after('id')->constrained()->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        foreach (['quotations', 'invoices', 'contracts'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropConstrainedForeignId('project_id');
            });
        }

        Schema::dropIfExists('projects');
    }
};
