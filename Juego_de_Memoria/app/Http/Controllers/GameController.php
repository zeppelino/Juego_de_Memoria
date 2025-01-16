<?php

namespace App\Http\Controllers;

use App\Models\Dificultad;
use App\Models\Partida;
use App\Models\Tiempo;
use App\Models\TipoCarta;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    /* Esta funcion es llamada por el dashboard al dar iniciar juego para cargar los selectores */
    public function index()
    {
        $dificultades = Dificultad::all();
        $tiposCartas = TipoCarta::all();
        $tiempos = Tiempo::all();

        return view('game', compact('dificultades', 'tiposCartas', 'tiempos'));
    }


    /* Esta funcion es llamada por iniciar juego envia datos al Board */
    public function iniciarPartida(Request $request) {
        $dificultad = $request->input('dificultad');
        $tipo_cartas = $request->input('tipo_cartas');
        $tiempo = $request->input('tiempo');
        $usuarioId = auth()->id();
    
        /* Buscar y verificar la dificultad en la base de datos */
        $dificultad = Dificultad::where('nombre', $dificultad)->first();
        $intentos = $dificultad->intentos;
    
        if (!$dificultad) {
            return redirect()->back()->withErrors(['error' => 'Dificultad no válida.']);
        }
    
        /*  Obtener intentos y número de cartas desde la dificultad */
        $cantidadCartas = $dificultad->numeros_cartas;
    
        /* Busco si hay una partida antes de empezar el juego */
        $ultimaPartida = Partida::where('user_id', $usuarioId)
        ->orderBy('id', 'desc')
        ->first();

        /* Veo si habia una partida sino la inicio en 1 */
        if ($ultimaPartida) {
            $partida = $ultimaPartida->numero_partida + 1; 
        } else {
            $partida = 1; 
        }
    
        /* VER EL GUARDADO */
        //*  Si no se encuentra, guardar la nueva partida, esto para */
       /*  if (!$ultimaPartida) {
            $this->guardarPartida($partida, $dificultad, $intentos, $tiempo, $tipo_cartas);
        } else {
            $intentos = $existente->intentos; 
        }
     */

     /* RANKING */
     $partidaModel = new Partida(); // Creo instancia del modelo
     $mejoresPartidas = $partidaModel->mejoresPartidas($usuarioId); // llamo instancia


        return view('board', compact('dificultad', 'tipo_cartas', 'tiempo','partida', 'cantidadCartas', 'mejoresPartidas'));
    }
    
    
      /*  public function start(Request $request)
    {
        $request->validate([
            'dificultad' => 'required|in:baja,media,alta',
            'tipo_cartas' => 'required|in:numeros,animales,imagenes',
            'tiempo' => 'required|in:5,10,20,ilimitado',
        ]);

        // Lógica para iniciar el juego según las opciones seleccionadas

        return redirect()->route('game.start')->with('success', '¡Partida iniciada correctamente!');
    } */


    /* Funcion para devolver la consulta del ranking  */
 /*    public function obtenerRanking()
    {
        $userId = Auth::id();

        $ranking = Partida::where('user_id', $userId)
            ->orderBy('tiempo', 'asc')
            ->limit(5)
            ->get(['id as numero_partida', 'tiempo', 'intentos', 'dificultad']);

        return response()->json($ranking);
    } */



}
