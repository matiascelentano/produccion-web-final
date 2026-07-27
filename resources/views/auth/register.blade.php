@extends('layouts.app')

@section('title', 'Registrarse')

@section('content')
    <div class="max-w-md mx-auto p-6">
        <h1 class="text-3xl font-bold mb-4">Crear cuenta</h1>

        @if ($errors->any())
            <div class="mb-4 rounded border border-red-200 bg-red-50 p-4 text-red-800">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700" for="name">Nombre</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700" for="last_name">Apellido</label>
                <input id="last_name" name="last_name" type="text" value="{{ old('last_name') }}" required class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700" for="birth_date">Fecha de nacimiento</label>
                <input id="birth_date" name="birth_date" type="date" value="{{ old('birth_date') }}" required class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700" for="username">Nombre de usuario</label>
                <input id="username" name="username" type="text" value="{{ old('username') }}" required class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700" for="email">Correo electrónico</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700" for="password">Contraseña</label>
                <input id="password" name="password" type="password" required class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700" for="password_confirmation">Confirmar contraseña</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
            </div>

            <button type="submit" class="w-full rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">Registrarme</button>
        </form>

        <p class="mt-4 text-sm text-gray-600">
            ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:underline">Inicia sesión</a>
        </p>
    </div>
@endsection
