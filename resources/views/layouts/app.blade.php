<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'D&D 5E Character Generator')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        @include('components.navigation')

        <!-- Alert Messages -->
        @if ($errors->any())
            @include('components.alert', ['type' => 'error', 'message' => 'Please fix the errors below.'])
        @endif

        @if (session('success'))
            @include('components.alert', ['type' => 'success', 'message' => session('success')])
        @endif

        @if (session('error'))
            @include('components.alert', ['type' => 'error', 'message' => session('error')])
        @endif

        @if (session('warning'))
            @include('components.alert', ['type' => 'warning', 'message' => session('warning')])
        @endif

        @if (session('info'))
            @include('components.alert', ['type' => 'info', 'message' => session('info')])
        @endif

        <!-- Main Content -->
        <main class="flex-1 py-8">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-gray-300 py-8 border-t border-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div>
                        <h3 class="text-white font-semibold mb-4">D&D Character Generator</h3>
                        <p class="text-sm">Create and manage your D&D 5E characters with ease.</p>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold mb-4">Quick Links</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="{{ route('characters.index') }}" class="hover:text-white transition">Characters</a></li>
                            <li><a href="{{ route('characters.create') }}" class="hover:text-white transition">Create Character</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-white font-semibold mb-4">About</h3>
                        <p class="text-sm">Built with Laravel 12 and PHP 8.4 for D&D 5E 2024 ruleset.</p>
                    </div>
                </div>
                <div class="mt-8 pt-8 border-t border-gray-800">
                    <p class="text-center text-sm">&copy; {{ date('Y') }} D&D Character Generator. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
