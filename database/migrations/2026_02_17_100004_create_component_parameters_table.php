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
        Schema::create('component_parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('component_id')->constrained()->onDelete('cascade');
            $table->string('name'); // impedancia, napatie, pomer
            $table->string('label'); // "Impedancia", "Primárne napätie"
            $table->enum('field_type', ['text', 'number', 'date', 'select'])->default('number');
            $table->boolean('is_required')->default(false);
            $table->string('unit')->nullable(); // "Ω", "V", "A", "kV"
            $table->decimal('min_value', 8, 2)->nullable();
            $table->decimal('max_value', 8, 2)->nullable();
            $table->json('options')->nullable(); // Pre select polia
            $table->integer('order')->default(0);
            $table->string('placeholder')->nullable();
            $table->string('help_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('component_parameters');
    }
};
