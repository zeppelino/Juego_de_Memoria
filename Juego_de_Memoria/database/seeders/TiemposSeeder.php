<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiemposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tiempos')->insert([
            ['valor' => '5', 'descripcion' => '5 minutos'],
            ['valor' => '10', 'descripcion' => '10 minutos'],
            ['valor' => '20', 'descripcion' => '20 minutos'],
            ['valor' => 'ilimitado', 'descripcion' => 'Sin límite de tiempo'],
        ]);
        
    }
}
