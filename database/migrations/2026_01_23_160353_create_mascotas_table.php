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
    Schema::create('mascotas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Relación con usuario
        $table->string('nombre');        // Tipo string
        $table->integer('edad');         // Tipo integer
        $table->string('especie');       // Tipo string
        $table->float('peso');           // Tipo float
        $table->boolean('vacunado');     // Tipo boolean
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};
