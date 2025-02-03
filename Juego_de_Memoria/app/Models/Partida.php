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


    public static function mejoresPartidas($userId)
    {

        return self::where('user_id', $userId)
            ->whereIn('resultado', ['ganada'])
            ->get()
            ->map(function ($partida) {
                // Convertir tiempos a formato de segundos para la resta
                $tiempoTotal = strtotime($partida->tiempo_total);
                $tiempoRestante = strtotime($partida->tiempo_restante);
                $diferenciaSegundos = max(0, $tiempoTotal - $tiempoRestante); // Asegurar no valores negativos

                // Convertir la diferencia de nuevo a formato de tiempo (H:i:s)
                $partida->tiempo_restante = gmdate('H:i:s', $diferenciaSegundos);

                // Añadir un campo adicional con el tiempo en segundos para ordenar
                $partida->tiempo_diferencia_segundos = $diferenciaSegundos;

                return $partida;
            })
            ->sortBy('tiempo_diferencia_segundos') // Ordeno los mas bajos
            ->take(5); 
    }
}
