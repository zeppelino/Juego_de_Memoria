@extends('layouts.app2')

{{-- @section('content')
<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-success text-white">
            <h3>Configuración del Juego 🧩</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('game.start') }}" method="POST">
                @csrf

                
                <!-- Dificultad -->
                <div class="mb-3">
                  <label for="dificultad" class="form-label">Dificultad</label>
                  <select class="form-select" id="dificultad" name="dificultad" required>
                      @foreach($dificultades as $dificultad)
                          <option value="{{ $dificultad->nombre }}">{{ $dificultad->descripcion }}</option>
                      @endforeach
                  </select>
              </div>

              <!-- Tipo de Cartas -->
              <div class="mb-3">
                  <label for="tipo_cartas" class="form-label">Tipo de Cartas</label>
                  <select class="form-select" id="tipo_cartas" name="tipo_cartas" required>
                      @foreach($tiposCartas as $tipo)
                          <option value="{{ $tipo->nombre }}">{{ $tipo->descripcion }}</option>
                      @endforeach
                  </select>
              </div>

              <!-- Tiempo -->
              <div class="mb-3">
                  <label for="tiempo" class="form-label">Tiempo Máximo</label>
                  <select class="form-select" id="tiempo" name="tiempo" required>
                      @foreach($tiempos as $tiempo)
                          <option value="{{ $tiempo->valor }}">{{ $tiempo->descripcion }}</option>
                      @endforeach
                  </select>
              </div>

                <button type="submit" class="btn btn-primary">🕹️ Comenzar Partida</button>
            </form>
        </div>
    </div>
</div>
@endsection --}}
@section('content')
<div class="container mt-5">
    @if(request('dificultad') && request('tipo_cartas') && request('tiempo'))
        <!-- Mostrar el tablero de juego -->
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3>🎮 ¡Partida en Curso!</h3>
            </div>
            <div class="card-body">
                <p><strong>Dificultad:</strong> {{ ucfirst(request('dificultad')) }}</p>
                <p><strong>Tipo de Cartas:</strong> {{ ucfirst(request('tipo_cartas')) }}</p>
                <p><strong>Tiempo Máximo:</strong> {{ request('tiempo') == 'ilimitado' ? 'Sin límite de tiempo' : request('tiempo') . ' minutos' }}</p>

                <!-- Aquí se podría generar dinámicamente el tablero de juego -->
                <div class="alert alert-info">El tablero se generará aquí según las configuraciones seleccionadas.</div>
            </div>
        </div>
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
@endsection
