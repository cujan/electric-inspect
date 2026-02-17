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
        Schema::create('inspection_kind_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspection_kind_id')->constrained()->onDelete('cascade');
            $table->string('name'); // DB column name: testerName, measurementDevice, humidity
            $table->string('label'); // UI label: "Meno testera", "Meracie zariadenie"
            $table->enum('field_type', ['text', 'textarea', 'number', 'date', 'datetime', 'select', 'checkbox'])->default('text');
            $table->boolean('is_required')->default(false);
            $table->integer('order')->default(0);
            $table->json('options')->nullable(); // Pre select pole: {"option1": "label1", "option2": "label2"}
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
        Schema::dropIfExists('inspection_kind_fields');
    }
};
