<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-base-200">

<div class="container mx-auto px-4 py-6">
    {{ $slot }}
</div>

</body>

</html>
