@extends('layouts.app2')

@section('content')

    {{-- <script>
  var baseUrl = "{{ asset('images/') }}";
</script> --}}


    <div class="container-fluid vh-100 d-flex flex-column">
        <div class="row flex-grow-1">

            {{-- Comienza la tabla --}}
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
                                    <th>Tiempo utilizado <br>(seg)</th>
                                    <th>Intentos</th>
                                    <th>Dificultad</th>
                                    <th>Tiempo <br> Seleccionado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($mejoresPartidas->isEmpty())
                                    <tr>
                                        <td colspan="5" class="text-center">No tienes partidas todavía.</td>
                                    </tr>
                                @else
                                    @foreach ($mejoresPartidas as $index => $partida)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            {{-- <td>{{ $partida->tiempo_restante }} minutos</td> --}}
                                            <td>
                                                @if ($partida->tiempo_restante == '00:00:00')
                                                    {{ 'S/T' }}
                                                @else
                                                    @php
                                                        $tiempoRestante = $partida->tiempo_restante;
                                                        [$horas, $minutos, $segundos] = explode(':', $tiempoRestante);
                                                    @endphp
                                                    {{ (int) $minutos }}:{{ (int) $segundos }}
                                                @endif



                                            </td>
                                            <td>{{ $partida->intentos }}</td>
                                            <td>{{ ucfirst($partida->dificultad) }}</td>
                                            {{-- <td>{{ ucfirst($partida->resultado) }}</td> --}}
                                            <td>
                                              @switch($partida->tiempo_total)
                                              @case('00:05:00')
                                                  {{'5 min'}}
                                                  @break
                                              @case('00:10:00')
                                                  {{'10 min'}}
                                                  @break
                                              @case('00:20:00')
                                                  {{'20 min'}}
                                                  @break
  
                                              @default
                                                {{ $partida->tiempo_total }}
                                                @endswitch
                                        
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <small class="text-muted" style="font-style: italic;">Nota: S/T =  Sin tiempo disponible</small>
                    </div>
                </div>
            </div>

            <!-- Sección de Juego -->
            <div class="col-md-8 p-2">
                <div class="card h-100 shadow-lg">
                    <div class="card-header bg-primary text-white py-2">
                        <h3>🎮 ¡Partida en Curso!</h3>
                    </div>
                    <div class="card-body">
                        <h4>📝 Detalles de la Partida</h4>

                        {{-- Primera fila --}}
                        <div class="row text-center mb-3">
                            <div class="col-md-3">
                                <p><strong>📄 Número de Partida:</strong> <span id="nroPartida">{{ $idPartida }}</span>
                                </p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Dificultad:</strong>
                                    {{ isset($dificultadNombre) ? $dificultadNombre : ucfirst($dificultad->nombre) }}
                                    {{-- {{ ucfirst($dificultad->nombre) }} --}}</p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Tipo de Cartas:</strong>
                                    {{ isset($tipo_cartas) ? $tipo_cartas : ucfirst($tipo_cartas) }}
                                    {{-- {{ ucfirst($tipo_cartas) }} --}}</p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Tiempo Máximo:</strong>
                                    @if (isset($tiempo_total))
                                        @switch($tiempo_total)
                                            @case('00:05:00')
                                                {{'5 min'}}
                                                @break
                                            @case('00:10:00')
                                                {{'10 min'}}
                                                @break
                                            @case('00:20:00')
                                                {{'20 min'}}
                                                @break

                                            @default
                                              {{ $tiempo_total }}
                                        @endswitch
                                        
                                    @else
                                        {{ $tiempo == 'ilimitado' ? 'Sin límite' : $tiempo . ' minutos' }}
                                    @endif
                                </p>
                            </div>
                        </div>

                        {{-- 2da fila --}}
                        <div class="row text-center mb-4">
                            <div class="col-md-3">
                                <p><strong>🎯 Aciertos:</strong> <span id="aciertos">0</span></p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>🔄 Intentos obtenidos:</strong> <span id="intentos">
                                        {{ isset($intentosObtenidos) ? $intentosObtenidos : $dificultad->intentos }}
                                        {{--  {{ $dificultad->intentos }} --}}
                                    </span></p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>🔄 Intentos:</strong> <span id="intentosRestantes">
                                @if (isset($intentos))
                                    {{$intentos}}
                                @endif  
                                </span></p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>⏱️ Tiempo Restante:</strong> <span id="tiempoTranscurrido"
                                        style="color: red">0:00</span></p>

                            </div>
                        </div>


                        <input type="hidden" name="nroPart" id="nroPartidaId"
                            value="{{ isset($idPartida) ? $idPartida : '' }}">
                        <input type="hidden" name="dificultad" id="dificultad"
                            value="{{ isset($dificultadNombre) ? $dificultadNombre : $dificultad->nombre }}">
                        <input type="hidden" name="nroCartas" id="nroCartasId"
                            value="{{ isset($nro_cartas) ? $nro_cartas : $dificultad->numero_de_cartas }}">
                        <input type="hidden" name="intentosObtenidos" id="intentosObtenidosId"
                            value="{{ isset($intentosObtenidos) ? $intentosObtenidos : $dificultad->intentos }}">
                        <input type="hidden" name="tipo_cartas_name" id="tipo_cartas"
                            value="{{ isset($tipo_cartas) ? $tipo_cartas : $tipo_cartas }}">
                        <input type="hidden" name="tiempoSeleccionado" id="tiempoSeleccionadoId"
                            value="{{ isset($tiempo_total) ? $tiempo_total : $tiempo }}">
                        <input type="text" name="idUser" id="idUser"
                            value="{{ isset($usuarioId) ? $usuarioId : $usuarioId }}" hidden>


                        {{-- <input type="text" name="ruta" id="rutaId" value="{{route('guardarPartida')}}" hidden> --}}

                    </div>
                </div>
            </div>

            <!-- Tablero del Juego -->
            @if (isset($esPartidaGuardada))
                <div id="tableroContinuar" 
                    data-idPartida ='{{ $idPartida ?? '' }}'
                    data-dificultad="{{ $dificultadNombre ?? '' }}"
                    data-tipo-cartas="{{ $tipo_cartas ?? '' }}"
                    data-tiempo-restante="{{ $tiempo_restante ?? '' }}" 
                    data-tiempo-total="{{ $tiempo_total ?? '' }}"
                    data-cartas='@json($cartas ?? '')' 
                    data-intentos="{{ $intentos ?? 0 }}"
                    data-aciertos="{{ $aciertos ?? 0 }}"
                    data-es-partida-guardada="{{ isset($esPartidaGuardada) ? 'true' : 'false' }}">
                </div>
            @endif
            <div class="container">
                <div id="tablero" class="row tablero justify-around">
                    {{-- aca se genera el tablero --}}
                </div>


                {{-- BOTONES DE RENDIRSE E INTERRUMPIR --}}

                <div class="botones">
                    <!-- Botón de Rendirse -->
                    <button class="btn btn-danger btn-accion" id="btnRendirse">🏳️ Rendirse</button>

                    <!-- Botón de Interrumpir -->
                    <button class="btn btn-warning btn-accion" id="btnInterrumpir">🛑 Interrumpir</button>
                </div>


            </div>
        </div>
    </div>

    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="{{ asset('js/todoJunto.js') }}"></script>


@endsection
