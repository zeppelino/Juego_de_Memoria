<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'mauri', // Cambia esto al nombre de usuario deseado
            'email' => 'mauri@gmail.com', // Cambia esto al email deseado
            'password' => Hash::make('Prueba1234#'), // Cambia esto a la contraseña deseada
            'date_of_birth' => '1990-01-01', // Cambia esto a la fecha de nacimiento deseada (formato YYYY-MM-DD)
        ]);
    }
}
