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
        Schema::create('inspection_component_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_component_id')->constrained()->onDelete('cascade');
            $table->foreignId('component_parameter_id')->constrained()->onDelete('cascade');
            $table->text('value')->nullable();
            $table->string('unit')->nullable(); // Prepísať sa môže jednotka, ak je iná ako default
            $table->timestamps();

            // Unique pair: každý parameter sa meria len raz na komponente
            $table->unique(['inspection_component_id', 'component_parameter_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_component_values');
    }
};
