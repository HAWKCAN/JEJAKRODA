<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Jejak Roda')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center" style="background-color: #F2EFE9;">

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold" style="color: #0C1B33;">Jejak Roda</h1>
            <p class="text-sm mt-1" style="color: #9A9488;">Platform Rental Kendaraan</p>
        </div>

        <div class="rounded-2xl p-8" style="background-color: #FFFFFF; border: 1px solid #D4CFC6;">
            @yield('content')
        </div>
    </div>

</body>
</html>