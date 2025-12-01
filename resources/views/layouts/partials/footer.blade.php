<footer class="bg-gray-800 text-gray-400 py-6 mt-auto">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <div class="text-center md:text-left">
                <p class="text-sm">
                    &copy; {{ date('Y') }} D&D Character Creator. All rights reserved.
                </p>
                <p class="text-xs mt-1">
                    Version {{ config('app.version', '1.0.0') }}
                </p>
            </div>
            <div class="text-center md:text-right text-xs">
                <p>
                    Dungeons &amp; Dragons is a trademark of Wizards of the Coast LLC.
                </p>
                <p class="mt-1">
                    This is a fan-made tool for personal use.
                </p>
            </div>
        </div>
    </div>
</footer>
