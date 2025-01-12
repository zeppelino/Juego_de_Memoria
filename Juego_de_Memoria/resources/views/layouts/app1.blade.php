<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Juego de Memoria') }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Css para mostrar la imagen de fondo --}}
    <link rel="stylesheet" href="{{ asset('css/fondo.css') }}">
    
    <link rel="stylesheet" href="{{ asset('css/styleLogReg.css') }}">
    <!-- Estilo para borde rojo en input password, evita que se corte por visualizador de password-->
   <link rel="stylesheet" href="{{ asset('css/styleLogin.css') }}">

</head>

<body>
  
  <main class="py-4">
    @yield('content')
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

{{-- script --}}
{{-- <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script> --}}
</body>
</html>