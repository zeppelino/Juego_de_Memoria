<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'resultado',
        'dificultad',
        'tipo_cartas',
        'tiempo',
        'intentos',
        'aciertos',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
