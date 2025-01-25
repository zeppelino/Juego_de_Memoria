<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposCartasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipos_cartas')->insert([
            ['nombre' => 'numeros', 'descripcion' => 'Números'],
            ['nombre' => 'animales', 'descripcion' => 'Animales'],
            ['nombre' => 'aviones', 'descripcion' => 'Aviones'],
        ]);
        
    }
}
