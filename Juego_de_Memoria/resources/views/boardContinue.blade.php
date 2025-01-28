@extends('layouts.app2')

@section('content')

<div class="container-fluid vh-100 d-flex flex-column">
    <div class="row flex-grow-1">
        
        {{-- Tabla de Ranking --}}
        <div class="col-md-4 p-2 responsivo">
            <div class="card h-100 shadow-lg">
                <div class="card-header bg-warning text-dark">
                    <h4>🏆 Ranking Personal</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="rankingTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tiempo (min)</th>
                                <th>Intentos</th>
                                <th>Dificultad</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($mejoresPartidas) && $mejoresPartidas->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center">No tienes partidas todavía.</td>
                                </tr>
                            @else
                                @foreach ($mejoresPartidas as $index => $partida)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @php
                                                $tiempoRestante = $partida->tiempo_restante ?? '00:00:00'; 
                                                list($horas, $minutos, $segundos) = explode(':', $tiempoRestante);
                                            @endphp
                                            {{ (int)$minutos }}:{{ (int)$segundos }}
                                        </td>
                                        <td>{{ $partida->intentos ?? '-' }}</td>
                                        <td>{{ ucfirst($partida->dificultad ?? 'N/A') }}</td>
                                        <td>{{ ucfirst($partida->resultado ?? 'N/A') }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Sección de Juego --}}
        <div class="col-md-8 p-2">
            <div class="card h-100 shadow-lg">
                <div class="card-header bg-primary text-white py-2">
                    <h3>🎮 ¡Partida en Curso!</h3>
                </div>
                <div class="card-body">
                    <h4>📝 Detalles de la Partida</h4>
                  @dd($partida)
                    {{-- Primera fila --}}
                    <div class="row text-center mb-3">
                        <div class="col-md-3">
                            <p><strong>📄 Número de Partida:</strong> <span id="nroPartida">{{ $partida->nro_partida ?? 'N/A' }}</span></p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Dificultad:</strong> {{ ucfirst($partida->dificultad->nombre ?? 'N/A') }}</p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Tipo de Cartas:</strong> {{ ucfirst($partida->tipo_cartas ?? 'N/A') }}</p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>Tiempo Máximo:</strong> 
                                {{ isset($partida->tiempo) && $partida->tiempo == 'ilimitado' ? 'Sin límite' : $partida->tiempo . ' minutos' }}
                            </p>
                        </div>
                    </div>

                    {{-- 2da fila --}}
                    <div class="row text-center mb-4">
                        <div class="col-md-3">
                            <p><strong>🎯 Aciertos:</strong> <span id="aciertos">0</span></p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>🔄 Intentos obtenidos:</strong> <span id="intentos">{{ $partida->dificultad->intentos ?? 0 }}</span></p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>🔄 Intentos:</strong> <span id="intentosRestantes"></span></p>
                        </div>
                        <div class="col-md-3">
                            <p><strong>⏱️ Tiempo Restante:</strong> <span id="tiempoTranscurrido" style="color: red">0:00</span></p>
                        </div>
                    </div>

                    {{-- Campos ocultos --}}
                    <input type="hidden" id="nroPartidaId" value="{{ $partida->nro_partida ?? '' }}">
                    <input type="hidden" id="dificultad" value="{{ $partida->dificultad->nombre ?? '' }}">
                    <input type="hidden" id="nroCartasId" value="{{ $partida->dificultad->numero_de_cartas ?? '' }}">
                    <input type="hidden" id="intentosObtenidosId" value="{{ $partida->dificultad->intentos ?? '' }}">
                    <input type="hidden" id="tipo_cartas" value="{{ $partida->tipo_cartas ?? '' }}">
                    <input type="hidden" id="tiempoSeleccionadoId" value="{{ $partida->tiempo ?? '' }}">
                    <input type="hidden" id="idUser" value="{{ $partida->user_ide ?? '' }}">

                </div>
            </div>
        </div>

        {{-- Tablero del Juego --}}
        <div class="container">
            <div id="tablero" class="row tablero justify-around">
                {{-- Aquí se genera el tablero dinámicamente --}}
            </div>

            {{-- Botones de Rendirse e Interrumpir --}}
            <div class="botones mt-3">
                <button class="btn btn-danger btn-accion" id="btnRendirse">🏳️ Rendirse</button>
                <button class="btn btn-warning btn-accion" id="btnInterrumpir">🛑 Interrumpir</button>
            </div>

        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="{{ asset('js/todoJunto.js') }}"></script>

@endsection
