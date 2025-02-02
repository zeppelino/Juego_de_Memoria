@extends('layouts.app1')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow" style="background-color: #f3f4f6; border: none;">
                <div class="card-header d-flex align-items-center" style="background-color: black; color: white;">
                    <a href="{{ route('welcome') }}" class="text-decoration-none">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 100px; margin-right: 20px;"> 
                    </a>
                    <h4 class="mb-0 ms-auto">Registro de Usuario</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <!-- Nombre de Usuario -->
                        <div class="mb-3">
                            <label for="username" class="form-label text-dark">Nombre de Usuario
                            </label>

                            <div class="tooltip-container">
                                <i class="icon">i</i> <!-- Ícono -->
                                <span class="tooltip-message">El usuario puede tener caracteres alfanúmericos incluyendo caracteres especiales.</span>
                            </div>

                            <input type="text" id="username" name="username" value="{{ old('username') }}" required autofocus autocomplete="username" 
                                   class="form-control @error('username') is-invalid @enderror">
                                   
                            @error('username')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Correo Electrónico -->
                        <div class="mb-3">
                            <label for="email" class="form-label text-dark">Correo Electrónico</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="username" 
                                   class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-3">
                            <label for="password" class="form-label text-dark">Contraseña
                            </label>
                            <div class="tooltip-container">
                                <i class="icon">i</i> <!-- Ícono -->
                                <span class="tooltip-message">La contraseña deberá tener: un caracter especial, una mayuscula, una minuscula, un número y un mínimo de 8 caracteres.</span>
                            </div>
                            <input type="password" id="password" name="password" required 
                                   class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label text-dark">Confirmar Contraseña</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required 
                                   class="form-control @error('password_confirmation') is-invalid @enderror">
                            @error('password_confirmation')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Fecha de Nacimiento -->
                        <div class="mb-3">
                            <label for="date_of_birth" class="form-label text-dark">Fecha de Nacimiento</label>
                            <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required 
                                   class="form-control @error('date_of_birth') is-invalid @enderror">
                            @error('date_of_birth')
                                <div class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Botón de Registro y enlace de inicio de sesión -->
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('login') }}" class="text-decoration-underline text-indigo-600">¿Ya tienes una cuenta?</a>
                            <button type="submit" class="btn btn-indigo" style="background-color: #6366F1; color: white;">
                                Registrarse
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('assets/libs/jquery/jquery.min.js')}}"></script>
@endsection