<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('inspections', function (Blueprint $table) {
            // Drop columns
            $table->dropColumn(['next_inspection_date', 'findings', 'recommendations']);

            // Change result from enum to string
            $table->string('result')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inspections', function (Blueprint $table) {
            // Restore columns
            $table->date('next_inspection_date')->nullable();
            $table->text('findings')->nullable();
            $table->text('recommendations')->nullable();

            // Restore result enum
            $table->enum('result', ['pass', 'fail', 'conditional', 'pending'])->default('pending')->change();
        });
    }
};
