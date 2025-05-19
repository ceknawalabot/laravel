<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Empire Admin Panel - Tanpa Sidebar</title>
    @livewireStyles
    <!-- Sertakan aset CSS dan JS Filament di sini jika diperlukan -->
</head>
<body>
    <div class="filament-content" style="margin-left: 0;">
        @yield('content')
    </div>
    @livewireScripts
</body>
</html>
