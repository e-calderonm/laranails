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
    Schema::create('services', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // RF C1
        $table->text('description')->nullable(); // RF C1
        $table->integer('duration_minutes'); // RF C2: Tiempo estimado (ej: 60)
        $table->decimal('price', 10, 2); // RF C1: Precio con 2 decimales
        $table->string('category'); // RF C2
        $table->boolean('is_active')->default(true); // Para "Eliminar" lógico sin borrar historial
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
