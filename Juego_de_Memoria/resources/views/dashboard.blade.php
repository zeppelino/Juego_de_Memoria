@extends('layouts.app2')

    {{-- Esta pagina muestra la pantalla que ve el jugador al iniciar sesion --}}

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3>Bienvenido, {{ ucfirst(Auth::user()->username) }} 🎉</h3>
        </div>
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

            <a href="{{ route('game') }}" class="btn btn-success mt-3">🎮 Iniciar Juego</a>
            <a href="{{ route('board') }}" class="btn btn-warning mt-3">🔄 Cargar Partida</a>
        </div>
    </div>
</div>
<script src="{{ asset('js/todoJunto.js') }}"></script>
@endsection
