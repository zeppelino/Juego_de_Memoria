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
        Schema::create('dificultades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');      // baja, media, alta
            $table->string('descripcion'); // "Baja (8 cartas)"
            $table->integer('numero_de_cartas');     // 8, 16, 32
            $table->integer('intentos');   // 24, 40, 64
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dificultades');
    }
};
