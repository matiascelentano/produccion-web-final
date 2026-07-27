@extends('layouts.app')

@section('title', 'Iniciar sesión')

@section('content')
    <div class="max-w-md mx-auto p-6">
        <h1 class="text-3xl font-bold mb-4">Iniciar sesión</h1>

        @if (session('url.intended'))
            <div class="mb-4 rounded border border-yellow-200 bg-yellow-50 p-4 text-yellow-800">
                Inicia sesión para agregar productos al carrito o acceder a tu wishlist.
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded border border-red-200 bg-red-50 p-4 text-red-800">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700" for="email">Correo electrónico</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700" for="password">Contraseña</label>
                <input id="password" name="password" type="password" required class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
                    <label for="remember" class="text-sm text-gray-600">Recuérdame</label>
                </div>
            </div>

            <button type="submit" class="w-full rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">Entrar</button>
        </form>

        <p class="mt-4 text-sm text-gray-600">
            ¿No tienes cuenta? <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:underline">Regístrate</a>
        </p>
    </div>
@endsection
