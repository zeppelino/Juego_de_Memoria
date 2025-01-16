@extends('layouts.app2')

@section('content')

    <div class="container-fluid vh-100 d-flex flex-column">
        <div class="row flex-grow-1">

            <div class="col-md-3 p-2">
                <div class="card h-100 shadow-lg">
                    <div class="card-header bg-warning text-dark">
                        <h4>🏆 Ranking Personal</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped" id="rankingTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tiempo</th>
                                    <th>Intentos</th>
                                    <th>Dificultad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($mejoresPartidas->isEmpty())
                                    <tr>
                                        <td colspan="4" class="text-center">No tienes partidas todavía.</td>
                                    </tr>
                                @else
                                    @foreach ($mejoresPartidas as $index => $partida)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $partida->tiempo }} minutos</td>
                                            <td>{{ $partida->intentos }}</td>
                                            <td>{{ ucfirst($partida->dificultad) }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Sección de Juego -->
            <div class="col-md-9 p-2">
                <div class="card h-100 shadow-lg">
                    <div class="card-header bg-primary text-white py-2">
                        <h3>🎮 ¡Partida en Curso!</h3>
                    </div>
                    <div class="card-body">
                        <h4>📝 Detalles de la Partida</h4>

                        {{-- Primera fila --}}
                        <div class="row text-center mb-3">
                            <div class="col-md-3">
                                <p><strong>📄 Número de Partida:</strong> <span id="nroPartida">{{ $partida }}</span>
                                </p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Dificultad:</strong> {{ ucfirst($dificultad->nombre) }}</p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Tipo de Cartas:</strong> {{ ucfirst($tipo_cartas) }}</p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Tiempo Máximo:</strong>
                                    {{ $tiempo == 'ilimitado' ? 'Sin límite' : $tiempo . ' minutos' }}</p>
                            </div>
                        </div>

                        {{-- 2da fila --}}
                        <div class="row text-center mb-4">
                            <div class="col-md-3">
                                <p><strong>🎯 Aciertos:</strong> <span id="aciertos">0</span></p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>🔄 Intentos obtenidos:</strong> <span
                                        id="intentos">{{ $dificultad->intentos }}</span></p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>🔄 Intentos Restantes:</strong> <span id="intentosRestantes"></span></p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>⏱️ Tiempo Transcurrido:</strong> <span id="tiempoTranscurrido">0:00</span></p>

                            </div>
                        </div>

                        {{-- campos ocultos --}}
                        <input type="hidden" name="nroCartas" id="nroCartasId" value="{{ $dificultad->numero_de_cartas }}">
                        <input type="hidden" name="tipo_cartas_name" id="tipo_cartas" value="{{ $tipo_cartas }}">
                        <input type="hidden" name="tiempoSeleccionado" id="tiempoSeleccionadoId"
                            value="{{ $tiempo }}">
                        <input type="hidden" name="intentosObtenidos" id="intentosObtenidosId"
                            value="{{ $dificultad->intentos }}">
                    </div>
                </div>
            </div>

            <!-- Tablero del Juego -->
            <div id="tablero" class="row g-2 justify-content-center tablero" >
                {{-- aca se genera el tablero --}}
            </div>

            {{--  PONER FORMULARIO PARA CAPTAR LOS DATOS SI SE RINDE  --}}
            {{--  <form action="{{ route('partida.rendirse') }}" method="POST" id="formRendirse">
            @csrf
            <input type="hidden" name="partida" value="{{ $partida }}">
            <input type="hidden" name="aciertos" value="0">
            <input type="hidden" name="intentos" value="0">
            <input type="hidden" name="tiempo" value="0">

          </form> --}}


            <!-- Botón de Rendirse -->
            <button class="btn btn-danger mt-3" id="btnRendirse">🏳️ Rendirse</button>
        </div>
    </div>
    </div>

    </div>
    </div>

    <!-- Scripts -->
    {{-- <script src="{{ asset('js/ranking.js') }}"></script> --}}
    <script src="{{ asset('js/tablero.js') }}" defer></script>
    <script src="{{ asset('js/tiempo.js') }}"></script>

@endsection
