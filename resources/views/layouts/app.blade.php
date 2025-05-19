<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Aplikasi Formulir')</title>
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="bg-gray-100 text-gray-900">
    <header class="bg-white shadow p-4 mb-6">
        <div class="container mx-auto">
            <h1 class="text-xl font-bold">Aplikasi Formulir</h1>
        </div>
    </header>

    <main class="container mx-auto">
        @yield('content')
    </main>

    <footer class="bg-white shadow p-4 mt-6 text-center text-sm text-gray-600">
        &copy; {{ date('Y') }} Aplikasi Formulir
    </footer>
    @livewireScripts
</body>
</html>
