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
    Schema::create('appointments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained(); // RF A4: Empleada/Admin que agenda
        $table->foreignId('client_id')->constrained()->onDelete('cascade'); // RF A2: Cliente seleccionado
        
        $table->date('date'); // RF A2: Fecha
        $table->time('start_time'); // RF A2: Hora inicio
        $table->time('end_time'); // Calculado según duración (RF A8)
        $table->integer('total_duration_minutes')->default(0); // RF A8
        $table->decimal('total_price', 10, 2)->default(0); // RF D3
        
        // Estados: 'pendiente', 'confirmada', 'cancelada', 'finalizada' (RF D1)
        $table->enum('status', ['pendiente', 'confirmada', 'cancelada', 'finalizada'])->default('pendiente');
        
        $table->text('notes')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
