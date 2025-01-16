<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dificultad extends Model
{
    
        protected $table = 'dificultades';

        use HasFactory;
        protected $fillable = ['nombre', 'descripcion, numero_de_cartas, intentos'];
    
}
