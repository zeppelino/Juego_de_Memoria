{{-- @extends('layouts.app2')

@section('content')
<div class="container text-center">
    <h1 class="mt-5">¡Bienvenido al Juego de Memoria!</h1>
    <p class="lead mt-3">
        Pon a prueba tu memoria. Encuentra todas las parejas de cartas volteando dos a la vez.  
        ¡Descubre todas las coincidencias en el menor tiempo posible!
    </p>
    <a href="{{ route('register') }}" class="btn btn-primary btn-lg mt-3">Comienza Ahora</a>
</div>
@endsection --}}

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego de Memoria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('css/fondo.css') }}">
    <link rel="stylesheet" href="{{ asset('css/generales.css') }}">
</head>
<body>

    <div class="content">
        <h1>JUEGO DE MEMORIA</h1>
        <p class="">¡Bienvenido al Juego de Memoria! El objetivo es encontrar las cartas emparejadas, desafiando tu memoria en el proceso. ¿Estás listo para comenzar?</p>

        <div>
            <a href="{{ route('login') }}" class="btn-custom">Iniciar Sesión</a>
            <a href="{{ route('register') }}" class="btn-custom ms-3">Registrarse</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
