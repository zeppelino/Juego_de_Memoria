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
            ['nombre' => 'baja', 'descripcion' => 'Baja (8 cartas)'],
            ['nombre' => 'media', 'descripcion' => 'Media (16 cartas)'],
            ['nombre' => 'alta', 'descripcion' => 'Alta (32 cartas)'],
        ]);
        
    }
}
