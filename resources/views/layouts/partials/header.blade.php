<header class="bg-gray-800 text-white shadow-lg">
    <nav class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-xl font-bold text-white hover:text-gray-300 transition-colors">
                    D&D Character Creator
                </a>
                <div class="hidden md:flex space-x-4">
                    <a href="{{ route('home') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('home') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} transition-colors">
                        Home
                    </a>
                    <a href="{{ route('characters.index') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('characters.*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} transition-colors">
                        Characters
                    </a>
                    <a href="{{ route('characters.create') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('characters.create') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }} transition-colors">
                        Create Character
                    </a>
                </div>
            </div>

            <div class="md:hidden">
                <button type="button" id="mobile-menu-button" aria-label="Open menu"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="hidden md:hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}"
                   class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    Home
                </a>
                <a href="{{ route('characters.index') }}"
                   class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('characters.*') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    Characters
                </a>
                <a href="{{ route('characters.create') }}"
                   class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('characters.create') ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white' }}">
                    Create Character
                </a>
            </div>
        </div>
    </nav>
</header>

@push('scripts')
<script>
    document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>
@endpush
