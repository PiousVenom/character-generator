@extends('layouts.app')

@section('title', 'Characters')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Characters</h1>
            <p class="text-gray-600 mt-2">Manage and view all your D&D characters</p>
        </div>
        <a href="{{ route('characters.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-6 rounded-lg transition">
            Create Character
        </a>
    </div>

    @if ($characters->isEmpty())
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m0 0h6m-6-6H6m0 0H0" />
            </svg>
            <h3 class="mt-2 text-lg font-medium text-gray-900">No characters yet</h3>
            <p class="mt-1 text-gray-600">Get started by creating your first D&D character.</p>
            <a href="{{ route('characters.create') }}" class="mt-6 inline-block bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg transition">
                Create your first character
            </a>
        </div>
    @else
        <!-- Characters Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($characters as $character)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition cursor-pointer border border-gray-200">
                    <a href="{{ route('characters.show', $character->id) }}" class="block p-6">
                        <!-- Character Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">{{ $character->name }}</h3>
                                <p class="text-sm text-gray-600">
                                    {{ $character->class?->name ?? 'Unknown Class' }} • Level {{ $character->level }}
                                </p>
                            </div>
                            <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-3 py-1 rounded-full">
                                {{ $character->species?->name ?? 'Unknown Species' }}
                            </span>
                        </div>

                        <!-- Character Stats -->
                        <div class="bg-gray-50 rounded p-4 mb-4">
                            <div class="grid grid-cols-3 gap-3">
                                <div class="text-center">
                                    <p class="text-2xl font-bold text-red-600">{{ $character->current_hit_points ?? '—' }}</p>
                                    <p class="text-xs text-gray-600">Hit Points</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-2xl font-bold text-blue-600">{{ $character->armor_class ?? '—' }}</p>
                                    <p class="text-xs text-gray-600">Armor Class</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-2xl font-bold text-green-600">{{ $character->proficiency_bonus ?? '—' }}</p>
                                    <p class="text-xs text-gray-600">Prof. Bonus</p>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Info -->
                        <div class="space-y-2 text-sm">
                            @if ($character->background)
                                <p class="text-gray-700">
                                    <span class="font-semibold">Background:</span> {{ $character->background->name }}
                                </p>
                            @endif
                            @if ($character->alignment)
                                <p class="text-gray-700">
                                    <span class="font-semibold">Alignment:</span> {{ $character->alignment->value }}
                                </p>
                            @endif
                        </div>

                        <!-- Experience -->
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-600">
                                <span class="font-semibold">Experience:</span> {{ number_format($character->experience_points ?? 0) }} XP
                            </p>
                        </div>
                    </a>

                    <!-- Actions -->
                    <div class="px-6 py-3 bg-gray-50 border-t border-gray-200 flex justify-between">
                        <a href="{{ route('characters.show', $character->id) }}" class="text-purple-600 hover:text-purple-700 text-sm font-semibold">
                            View
                        </a>
                        <a href="{{ route('characters.show', $character->id) }}" class="text-gray-600 hover:text-gray-700 text-sm font-semibold">
                            Edit
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
