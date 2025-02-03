<?php

namespace App\Http\Controllers;

use App\Models\Dificultad;
use App\Models\Partida;
use App\Models\Tiempo;
use App\Models\TipoCarta;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use function Illuminate\Log\log;

class GameController extends Controller
{


    /* Esta funcion es llamada por el dashboard al dar iniciar juego para cargar los selectores */
    public function index(){
        $dificultades = Dificultad::all();
        $tiposCartas = TipoCarta::all();
        $tiempos = Tiempo::all();


        return view('game', compact('dificultades', 'tiposCartas', 'tiempos'));
    }


    /* FUNCION LLAMADA POR INICIAR JUEGO PARA ENVIAR DATOS A BOARD*/
    public function iniciarPartida(Request $request) {
        $dificultad = $request->input('dificultad');
        $tipo_cartas = $request->input('tipo_cartas');
        $tiempo = $request->input('tiempo');
        
        if (Auth::check()) {
            $usuarioId = Auth::id();
        } else {
            // Manejar el caso en que el usuario no está autenticado
            return redirect()->route('login');
        }
    
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
        ->orderBy('nro_partida', 'desc')
        ->first();

        /* Veo si habia una partida sino la inicio en 1 */
        if ($ultimaPartida) {
            $idPartida = $ultimaPartida->nro_partida + 1; 
        } else {
            $idPartida = 1; 
        }
    


     /* RANKING */
     $mejoresPartidas = $this->buscarRanking($usuarioId);

        return view('board', compact('dificultad', 'tipo_cartas', 'tiempo','idPartida', 'cantidadCartas', 'mejoresPartidas', 'usuarioId'));
    }
    
    
    
    /* FUNCION PARA GUARDAR LA PARTIDA */
    
    public function guardarPartida(Request $request){


        $request->validate([
        'resultado' => 'required|string',
        'nro_partida' => 'required|integer',
        'dificultad' => 'required|string',
        'tipo_cartas' => 'required|string',
        'tiempo_total' => 'required|date_format:H:i:s',
        'intentos' => 'required|integer',
        'aciertos' => 'required|integer',
        'tiempo_restante' => 'required|date_format:H:i:s',
        'estado_cartas' => 'nullable|array',
        'estado' =>'required|string'
    ]);

    try {
        Partida::create([
            'user_id' => Auth::id(),
            'resultado' => $request->resultado,
            'nro_partida' => $request->nro_partida,
            'dificultad' => $request->dificultad,
            'tipo_cartas' => $request->tipo_cartas,
            'tiempo_total' => $request->tiempo_total,
            'intentos' => $request->intentos,
            'aciertos' => $request->aciertos,
            'tiempo_restante' => $request->tiempo_restante,
            'estado_cartas' => json_encode($request->estado_cartas),
            'estadoPartida' => $request->estado,
        ]);

       return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al guardar la partida.'.$e], 500);
    }

}

/* FUNCION PARA TERMINAR PARTIDA */
public function finalizar($nro_partida){
    
    //buscar el id de usuario
    $usuarioId = Auth::id();
    
    // buscar con el id de la partida y el id del usuario
    $partida = Partida::where('nro_partida', $nro_partida)
    ->where('user_id', $usuarioId)
    ->first();
    
    if (!$partida) {
        return redirect()->back()->withErrors(['error' => 'Partida no encontrada.']);
    }
    
    // solo cambio resultado a "abandonada" y estadoPartida a "finalizada"
    $partida->update([
        'resultado' => 'abandonada',
        'estadoPartida' => 'finalizada'
    ]);
    
    $partida->save();
    
    return redirect()->route('dashboard');
}

/* FUNCION PARA CONTINUAR CON LA PARTIDA */

public function continuarPartida($idPartida){

    $idUsuario = Auth::id();

    $partida = Partida::where('nro_partida', $idPartida)
        ->where('user_id', $idUsuario)
        ->firstOrFail();

        $dificultad = Dificultad::where('nombre', $partida->dificultad)->first();
        $intentosObtenidos = $dificultad->intentos;

    $mejoresPartidas = $this->buscarRanking($idUsuario);
    $cantidadCartas = $dificultad->numero_de_cartas;

    $tiempoTotal = $partida->tiempo_total === '00:00:00' ? 'ilimitado' : $partida->tiempo_total;


    return view('board', [
        'mejoresPartidas' => $mejoresPartidas,
        'intentosObtenidos' => $intentosObtenidos, 
        'idPartida'=> $idPartida,
        'usuarioId' => $idUsuario,
        'dificultadNombre' => $partida->dificultad,
        'nro_cartas' => $cantidadCartas,
        'tipo_cartas' => $partida->tipo_cartas,
        'tiempo_restante' => $partida->tiempo_restante,
        'tiempo_total' => $tiempoTotal /* $partida->tiempo_total */,
        'cartas' => json_decode($partida->estado_cartas, true), 
        'intentos' => $partida->intentos,
        'aciertos' => $partida->aciertos,
        'esPartidaGuardada' => true,  // Bandera para saber si es una partida guardada
    ]);
}

/* BUSCAR LOS RANKINGS */
public function buscarRanking($usuarioId){

    $partidaModel = new Partida(); // Creo instancia del modelo
    return $partidaModel->mejoresPartidas($usuarioId); // llamo instancia
}

/* INTERRUPCION DE LA PARTIDA DESPUES DE LA 2DA VEZ */
public function interrumpir(Request $request){
    $request->validate([
        'resultado' => 'required|string',
        'nro_partida' => 'required|integer',
        'dificultad' => 'required|string',
        'tipo_cartas' => 'required|string',
        'tiempo_total' => 'required|date_format:H:i:s',
        'intentos' => 'required|integer',
        'aciertos' => 'required|integer',
        'tiempo_restante' => 'required|date_format:H:i:s',
        'estado_cartas' => 'nullable|array',
        'estado' => 'required|string',
    ]);
    
    try {
        // Buscar la partida por nro_partida e id del usuario autenticado
        $partida = Partida::where('nro_partida', $request->nro_partida)
            ->where('user_id', Auth::id())
            ->first();
    
        if (!$partida) {
            // Si la partida no existe, retornar un error
            return response()->json(['error' => 'Partida no encontrada'], 404);
        }
    
        // Actualizar los datos de la partida
        $partida->update([
            'resultado' => $request->resultado,
            'dificultad' => $request->dificultad,
            'tipo_cartas' => $request->tipo_cartas,
            'tiempo_total' => $request->tiempo_total,
            'intentos' => $request->intentos,
            'aciertos' => $request->aciertos,
            'tiempo_restante' => $request->tiempo_restante,
            'estado_cartas' => json_encode($request->estado_cartas),
            'estadoPartida' => $request->estado,
        ]);
    
        return response()->json(['success' => true, 'message' => 'Partida actualizada correctamente']);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Error al actualizar la partida: ' . $e->getMessage()], 500);
    }
}




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
