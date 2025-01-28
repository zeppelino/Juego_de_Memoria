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

    /* funcion para buscar las mejores partidas */
    /* public static function mejoresPartidas($userId)
    {
        return self::where('user_id', $userId)
            ->orderBy('tiempo_restante', 'asc') 
            ->take(5)
            ->get(); 
    } */
    public static function mejoresPartidas($userId)
    {
        /* return self::where('user_id', $userId)
            ->whereIn('resultado', ['ganada', 'perdida']) 
            ->orderBy('tiempo_restante', 'asc')
            ->take(5)
            ->get();
 */
            return self::where('user_id', $userId)
    ->whereIn('resultado', ['ganada'])
    /* ->where('tiempo_restante', '!=', '00:00:00') */ // Filtrar partidas con tiempo válido
    ->orderBy('tiempo_restante', 'desc')
    ->take(5)
    ->get();
    }
}
