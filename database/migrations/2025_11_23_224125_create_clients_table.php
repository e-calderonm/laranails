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
    Schema::create('clients', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // RF B1
        $table->string('last_name'); // RF B1
        $table->string('email')->unique(); // RF B1
        $table->string('phone'); // RF B1
        $table->string('alias')->nullable(); // RF B1
        $table->string('cedula')->unique()->nullable(); // RF B1
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
