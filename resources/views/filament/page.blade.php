<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Filament Admin Panel</title>
    <!-- Include Filament CSS and JS assets here if needed -->
    @livewireStyles
</head>
<body>
    <div class="filament-content">
        @yield('content')
    </div>
    @livewireScripts
</body>
</html>
