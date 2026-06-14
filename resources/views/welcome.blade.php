<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ __('Welcome') }} - {{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>

<body>
    <div class="flex min-h-screen flex-col items-center justify-center bg-gray-100 dark:bg-gray-900">
        <h1 class="text-4xl font-bold text-gray-800 dark:text-gray-200">Welcome to <span
                class="text-green-50 text-5xl">Mi</span>Study</h1>
        <p class="mt-4 text-lg text-gray-600 dark:text-gray-400">Your application is ready.</p>

    </div>
</body>

</html>