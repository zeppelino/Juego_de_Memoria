<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DificultadesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dificultades')->insert([
            ['nombre' => 'baja', 'descripcion' => 'Baja (8 cartas)', 'numero_de_cartas' => 8, 'intentos' => 24],
            ['nombre' => 'media', 'descripcion' => 'Media (16 cartas)', 'numero_de_cartas' => 16, 'intentos' => 40],
            ['nombre' => 'alta', 'descripcion' => 'Alta (32 cartas)', 'numero_de_cartas' => 32, 'intentos' => 64],
        ]);
        
    }
}
