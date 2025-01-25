<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Juego de Memoria') }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Estilos propios -->
    <link rel="stylesheet" href="{{ asset('css/fondo.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/tablero.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>



</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="{{ route('dashboard') }}" class="text-decoration-none">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 100px; margin-right: 20px;"> 
            </a>

            <h1 class="navbar-brand mb-0 text-white text-center" style="flex-grow: 1; margin-left: 270px;">EMPAREJADOS</h1> 

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                        </li>
                    @else
                     {{--    <li class="nav-item">
                               {{ ucfirst( Auth::user()->username )}}
                        </li> --}}
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                            
                                <button class="btn btn-link nav-link" type="submit">Cerrar Sesión de {{ ucfirst( Auth::user()->username )}}</button>
                            </form>
                        </li>
                    @endguest
                </ul>
            </div>
            <div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
