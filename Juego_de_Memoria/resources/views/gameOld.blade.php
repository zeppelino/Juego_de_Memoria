@extends('layouts.app2')

@section('content')

<div class="container mt-5">
    @if(request('dificultad') && request('tipo_cartas') && request('tiempo'))
   
    {{-- aca cargo el tablero  --}}
        @include('board', [
            'dificultad' => request('dificultad'),
            'tipo_cartas' => request('tipo_cartas'),
            'tiempo' => request('tiempo')
        ])

    @else
        <!-- Mostrar el formulario de configuración -->
        <div class="card shadow-lg">
            <div class="card-header bg-success text-white">
                <h3>Configuración del Juego 🧩</h3>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ url()->current() }}">
                  
                    <!-- Dificultad -->
                    <div class="mb-3">
                        <label for="dificultad" class="form-label">Dificultad</label>
                        <select class="form-select" id="dificultad" name="dificultad" required>
                            <option value="" disabled selected>Selecciona una dificultad</option>
                            @foreach($dificultades as $dificultad)
                                <option value="{{ $dificultad->nombre }}">{{ $dificultad->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tipo de Cartas -->
                    <div class="mb-3">
                        <label for="tipo_cartas" class="form-label">Tipo de Cartas</label>
                        <select class="form-select" id="tipo_cartas" name="tipo_cartas" required>
                            <option value="" disabled selected>Selecciona el tipo de cartas</option>
                            @foreach($tiposCartas as $tipo)
                                <option value="{{ $tipo->nombre }}">{{ $tipo->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tiempo -->
                    <div class="mb-3">
                        <label for="tiempo" class="form-label">Tiempo Máximo</label>
                        <select class="form-select" id="tiempo" name="tiempo" required>
                            <option value="" disabled selected>Selecciona el tiempo máximo</option>
                            @foreach($tiempos as $tiempo)
                                <option value="{{ $tiempo->valor }}">{{ $tiempo->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">🕹️ Comenzar Partida</button>
                </form>
            </div>
        </div>
    @endif
</div>
<!-- Scripts -->
<script src="{{ asset('js/ranking.js') }}"></script>
<script src="{{ asset('js/tablero.js') }}"></script>
<script src="{{ asset('js/tiempo.js') }}"></script>

@endsection
