<?php

namespace App\Http\Controllers;

use App\Models\Dificultad;
use App\Models\Tiempo;
use App\Models\TipoCarta;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index()
    {
        $dificultades = Dificultad::all();
        $tiposCartas = TipoCarta::all();
        $tiempos = Tiempo::all();

        return view('game', compact('dificultades', 'tiposCartas', 'tiempos'));
    }

    public function start(Request $request)
    {
        $request->validate([
            'dificultad' => 'required|in:baja,media,alta',
            'tipo_cartas' => 'required|in:numeros,animales,imagenes',
            'tiempo' => 'required|in:5,10,20,ilimitado',
        ]);

        // Lógica para iniciar el juego según las opciones seleccionadas

        return redirect()->route('game.start')->with('success', '¡Partida iniciada correctamente!');
    }
}
