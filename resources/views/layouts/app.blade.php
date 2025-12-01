<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'D&D Character Creator')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="min-h-screen bg-gray-100 flex flex-col">
    @include('layouts.partials.header')

    <main class="flex-grow container mx-auto px-4 py-8">
        @include('layouts.partials.flash-messages')
        @yield('content')
    </main>

    @include('layouts.partials.footer')
    @stack('scripts')
</body>
</html>
