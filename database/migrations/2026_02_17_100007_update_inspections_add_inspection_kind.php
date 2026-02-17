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
            // Pridaj FK na inspection_kind
            $table->foreignId('inspection_kind_id')->nullable()->constrained()->onDelete('set null')->after('organization_id');
            
            // Zmaz stary inspection_type string
            // NOTE: Dáta sa migrujú v separate migrácii
            // $table->dropColumn('inspection_type'); // To urobíme v ďalšej migrácii po backup-e
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inspections', function (Blueprint $table) {
            $table->dropForeign(['inspection_kind_id']);
            $table->dropColumn('inspection_kind_id');
        });
    }
};
