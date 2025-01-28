@extends('layouts.app2')

    {{-- Esta pagina muestra la pantalla que ve el jugador al iniciar sesion --}}

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3>Bienvenido, {{ ucfirst(Auth::user()->username) }} 🎉</h3>
        </div>
        <a href="{{ route('game') }}" class="btn btn-success mt-3">🎮 INICIAR JUEGO</a>
        <div class="card-body">
            @if(isset($ultimaPartida))
                <p><strong>Última Partida:</strong></p>
                <ul>
                    <li><strong>Fecha:</strong> {{ $ultimaPartida->created_at->format('d/m/Y') }}, <strong>Hora:</strong> {{ $ultimaPartida->created_at->format('H:i') }} </li>
                    <li><strong>Resultado:</strong> Partida  {{ucfirst( $ultimaPartida->resultado) }}</li>
                    <li><strong>Dificultad:</strong> {{ ucfirst($ultimaPartida->dificultad ) }}</li>
                </ul>
            @else
                <p>No has jugado ninguna partida aún.</p>
            @endif

<hr>
           {{--  <a href="{{ route('game') }}" class="btn btn-success mt-3">🎮 Iniciar Juego</a> --}}

            {{-- PARTIDAS EN CURSO --}}
            <h4 class="mt-4">🔄 Partidas en curso</h4>
            @if($partidasActivas->isNotEmpty())
                <table class="table table-bordered mt-3">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Dificultad</th>
                            <th>Tipo de Cartas</th>
                            <th>Intentos</th>
                            <th>Aciertos</th>
                            <th>Tiempo Restante</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($partidasActivas as $partida)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ ucfirst($partida->dificultad) }}</td>
                                <td>{{ ucfirst($partida->tipo_cartas) }}</td>
                                <td>{{ $partida->intentos }}</td>
                                <td>{{ $partida->aciertos }}</td>
                                <td>{{ $partida->tiempo_restante }}</td>
                                <td class="d-flex justify-content-around">
                                    <a href="{{ route('continuarPartida', $partida->id) }}" class="btn btn-info btn-sm">▶ Continuar</a>
                                    <a href="{{ route('finalizar', $partida->id) }}" class="btn btn-danger btn-sm">🏁 Finalizar</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">No tienes partidas activas actualmente.</p>
            @endif


        </div>
    </div>
</div>
<script src="{{ asset('js/todoJunto.js') }}"></script>
@endsection
