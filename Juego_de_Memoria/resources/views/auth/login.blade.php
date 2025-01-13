@extends('layouts.app1')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow" style="background-color: #f3f4f6; border: none;">
                <div class="card-header d-flex align-items-center" style="background-color: black; color: white;">
                    <a href="{{ route('welcome') }}" class="text-decoration-none">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 100px; margin-right: 20px;"> 
                    </a>
                    <h4 class="mb-0 ms-auto">Iniciar Sesión</h4>
                </div>

                <div class="card-body">

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
 
                        <!-- Usuario -->
                        <div class="mb-3">
                            <label for="username" class="form-label text-dark">Nombre de Usuario</label>
                            <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus autocomplete="username" 
                                   class="form-control @error('username') is-invalid @enderror">
                            @error('username')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
 
                        <!-- Contraseña -->
                        <div class="mb-3">
                            <label for="password" class="form-label text-dark">Contraseña</label>
                            <input type="password" id="password" name="password" required autocomplete="current-password" 
                                   class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Botón de Inicio de Sesión -->
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('register') }}" class="text-decoration-underline text-indigo-600">¿No tienes cuenta?</a>
                            <button type="submit" class="btn btn-indigo" style="background-color: #6366F1; color: white;">
                                Iniciar Sesión
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('../js/login.js') }}"></script> <!-- Corregido el tag script -->
@endsection
