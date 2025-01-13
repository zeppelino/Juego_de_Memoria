@extends('layouts.app2')

    {{-- Esta pagina muestra la pantalla que ve el jugador al iniciar sesion --}}

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3>Bienvenido, {{ Auth::user()->name }} 🎉</h3>
        </div>
        <div class="card-body">
            @if(isset($ultimaPartida))
                <p><strong>Última Partida:</strong></p>
                <ul>
                    <li><strong>Fecha:</strong> {{ $ultimaPartida->created_at->format('d/m/Y H:i') }}</li>
                    <li><strong>Resultado:</strong> {{ $ultimaPartida->resultado }}</li>
                </ul>
            @else
                <p>No has jugado ninguna partida aún.</p>
            @endif

            <a href="{{ route('game') }}" class="btn btn-success mt-3">🎮 Iniciar Juego</a>
        </div>
    </div>
</div>
@endsection
