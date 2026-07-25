<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Admin - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="flex">
        @include('admin.partials.sidebar')

        <main class="flex-1">
            @yield('content')
        </main>
    </div>
</body>
</html>