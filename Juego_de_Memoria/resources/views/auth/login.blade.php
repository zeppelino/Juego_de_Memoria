{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- User-->
        <div>
            <x-input-label for="user" :value="__('Usuario')" />
            <x-text-input id="user" class="block mt-1 w-full" type="email" name="email" :value="old('user')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('user')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('register') }}">
                {{ __('No estas registrado?') }}
            </a>

            <x-primary-button class="ms-3">
                {{ __('Iniciar Sesión') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
 --}}
 @extends('layouts.app1')

 @section('content')
 <div class="container mt-5">
     <div class="row justify-content-center">
         <div class="col-md-6">
             <div class="card shadow" style="background-color: #f3f4f6; border: none;">
                 <div class="card-header text-center" style="background-color: #6366F1; color: white;">
                     <h4>Iniciar Sesión</h4>
                 </div>
                 <div class="card-body">
                     <form method="POST" action="{{ route('login') }}">
                         @csrf
 
                         <!-- Usuario -->
                         <div class="mb-3">
                             <label for="user" class="form-label text-dark">Correo Electrónico</label>
                             <input type="email" id="user" name="email" value="{{ old('user') }}" required autofocus autocomplete="username" 
                                    class="form-control @error('user') is-invalid @enderror">
                             @error('user')
                                 <div class="invalid-feedback">
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
                                 <div class="invalid-feedback">
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
 @endsection
 