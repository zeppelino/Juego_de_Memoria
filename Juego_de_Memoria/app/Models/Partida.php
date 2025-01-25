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
        'nro_partida',
        'dificultad',
        'tipo_cartas',
        'tiempo_total',
        'tiempo_restante',
        'intentos',
        'aciertos',
        'estado_cartas',
        'estadoPartida',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* funcion para buscar las mejores partidas se utiliza en el ranking  */
    public static function mejoresPartidas($userId)
    {
        return self::where('user_id', $userId)
            ->orderBy('tiempo_restante', 'asc') 
            ->take(5)
            ->get(); 
    }
}
