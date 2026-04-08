<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>VotAfrica Admin</title>
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @fluxAppearance
</head>
<body class="antialiased min-h-screen" style="background: linear-gradient(135deg, #0f172a 0%, #1a2744 50%, #0f172a 100%); font-family: 'Instrument Sans', ui-sans-serif, system-ui, sans-serif;">
    <div class="min-h-screen flex items-center justify-center p-4 sm:p-6">
        <div class="w-full" style="max-width: 420px;">
            {{ $slot }}
        </div>
    </div>
    @livewireScripts
    @fluxScripts
</body>
</html>
