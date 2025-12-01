@extends('layouts.app')

@section('title', 'Home - D&D Character Creator')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
            D&D 5th Edition Character Creator
        </h1>
        <p class="text-xl text-gray-600">
            Create and manage your Dungeons &amp; Dragons characters with the 2024 ruleset.
        </p>
    </div>

    <div class="grid md:grid-cols-2 gap-8 mb-12">
        <a href="{{ route('characters.create') }}"
           class="block p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow border-2 border-transparent hover:border-blue-500">
            <div class="flex items-center mb-4">
                <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <h2 class="ml-4 text-2xl font-semibold text-gray-900">Create Character</h2>
            </div>
            <p class="text-gray-600">
                Build a new character from scratch. Choose your species, class, background, and more.
            </p>
        </a>

        <a href="{{ route('characters.index') }}"
           class="block p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow border-2 border-transparent hover:border-green-500">
            <div class="flex items-center mb-4">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h2 class="ml-4 text-2xl font-semibold text-gray-900">My Characters</h2>
            </div>
            <p class="text-gray-600">
                View and manage your existing characters. Track progression and update details.
            </p>
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-6">Features</h2>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-600 mt-1 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <div>
                    <h3 class="font-medium text-gray-900">2024 Ruleset</h3>
                    <p class="text-sm text-gray-600">Built for the latest D&D 5th Edition rules.</p>
                </div>
            </div>
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-600 mt-1 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <div>
                    <h3 class="font-medium text-gray-900">Complete Classes</h3>
                    <p class="text-sm text-gray-600">All 12 core classes with subclass options.</p>
                </div>
            </div>
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-600 mt-1 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <div>
                    <h3 class="font-medium text-gray-900">Species Options</h3>
                    <p class="text-sm text-gray-600">Choose from diverse species backgrounds.</p>
                </div>
            </div>
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-600 mt-1 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <div>
                    <h3 class="font-medium text-gray-900">Equipment</h3>
                    <p class="text-sm text-gray-600">Full equipment and inventory management.</p>
                </div>
            </div>
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-600 mt-1 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <div>
                    <h3 class="font-medium text-gray-900">Spellcasting</h3>
                    <p class="text-sm text-gray-600">Spell management for caster classes.</p>
                </div>
            </div>
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-600 mt-1 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <div>
                    <h3 class="font-medium text-gray-900">Feats</h3>
                    <p class="text-sm text-gray-600">Origin feats and advancement options.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
