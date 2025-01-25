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
        Schema::create('partidas', function (Blueprint $table) {
            $table->id();
            $table->integer('nro_partida');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('resultado', ['ganada', 'perdida']);
            $table->string('dificultad');
            $table->string('tipo_cartas');
            $table->time('tiempo_total'); 
            $table->time('tiempo_restante'); 
            $table->integer('intentos');
            $table->integer('aciertos');
            $table->json('estado_cartas')->nullable();
            $table->enum('estadoPartida', ['activa', 'finalizada']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partidas');
    }
};
