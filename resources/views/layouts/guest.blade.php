<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Inicio de Sesión Corporativo</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Custom Scrollbar if needed */
    </style>
</head>

<body
    class="bg-[#F8FAFC] dark:bg-[#0F172A] text-slate-800 dark:text-slate-100 min-h-screen transition-colors duration-300">
    {{ $slot }}

    <!-- Theme Override - Always Light for Login -->
    <script>
        document.documentElement.classList.remove('dark');
        document.documentElement.classList.add('light');
    </script>
</body>

</html>