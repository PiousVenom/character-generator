@extends('layouts.app')

@section('title', 'Create Character')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Create New Character</h1>
        <p class="text-gray-600 mt-2">Build your D&D 5E character step by step</p>
    </div>

    <!-- Form -->
    <form action="{{ route('characters.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Basic Information Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Basic Information</h2>

            <!-- Character Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                    Character Name <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Enter your character's name"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 {{ $errors->has('name') ? 'border-red-500' : '' }}"
                    required
                />
                @if ($errors->has('name'))
                    <p class="mt-1 text-sm text-red-600">{{ $errors->first('name') }}</p>
                @endif
            </div>

            <!-- Class Selection -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label for="classId" class="block text-sm font-semibold text-gray-700 mb-2">
                        Class <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="classId"
                        name="classId"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 {{ $errors->has('classId') ? 'border-red-500' : '' }}"
                        required
                    >
                        <option value="">Select a class</option>
                        <option value="">Artificer</option>
                        <option value="">Barbarian</option>
                        <option value="">Bard</option>
                        <option value="">Cleric</option>
                        <option value="">Druid</option>
                        <option value="">Fighter</option>
                        <option value="">Monk</option>
                        <option value="">Paladin</option>
                        <option value="">Ranger</option>
                        <option value="">Rogue</option>
                        <option value="">Sorcerer</option>
                        <option value="">Warlock</option>
                        <option value="">Wizard</option>
                    </select>
                    @if ($errors->has('classId'))
                        <p class="mt-1 text-sm text-red-600">{{ $errors->first('classId') }}</p>
                    @endif
                </div>

                <!-- Species Selection -->
                <div>
                    <label for="speciesId" class="block text-sm font-semibold text-gray-700 mb-2">
                        Species <span class="text-red-500">*</span>
                    </label>
                    <select
                        id="speciesId"
                        name="speciesId"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 {{ $errors->has('speciesId') ? 'border-red-500' : '' }}"
                        required
                    >
                        <option value="">Select a species</option>
                        <option value="">Dragonborn</option>
                        <option value="">Dwarf</option>
                        <option value="">Elf</option>
                        <option value="">Gnome</option>
                        <option value="">Goliath</option>
                        <option value="">Half-Elf</option>
                        <option value="">Half-Orc</option>
                        <option value="">Halfling</option>
                        <option value="">Human</option>
                        <option value="">Orc</option>
                        <option value="">Tiefling</option>
                    </select>
                    @if ($errors->has('speciesId'))
                        <p class="mt-1 text-sm text-red-600">{{ $errors->first('speciesId') }}</p>
                    @endif
                </div>
            </div>

            <!-- Background and Alignment -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="backgroundId" class="block text-sm font-semibold text-gray-700 mb-2">
                        Background
                    </label>
                    <select
                        id="backgroundId"
                        name="backgroundId"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                    >
                        <option value="">Select a background</option>
                        <option value="">Acolyte</option>
                        <option value="">Charlatan</option>
                        <option value="">Criminal</option>
                        <option value="">Entertainer</option>
                        <option value="">Folk Hero</option>
                        <option value="">Guild Artisan</option>
                        <option value="">Hermit</option>
                        <option value="">Noble</option>
                        <option value="">Outlander</option>
                        <option value="">Sage</option>
                        <option value="">Sailor</option>
                        <option value="">Soldier</option>
                        <option value="">Urchin</option>
                    </select>
                </div>

                <div>
                    <label for="alignment" class="block text-sm font-semibold text-gray-700 mb-2">
                        Alignment
                    </label>
                    <select
                        id="alignment"
                        name="alignment"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                    >
                        <option value="">Select alignment</option>
                        <option value="">Lawful Good</option>
                        <option value="">Neutral Good</option>
                        <option value="">Chaotic Good</option>
                        <option value="">Lawful Neutral</option>
                        <option value="">True Neutral</option>
                        <option value="">Chaotic Neutral</option>
                        <option value="">Lawful Evil</option>
                        <option value="">Neutral Evil</option>
                        <option value="">Chaotic Evil</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Character Stats Section -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Starting Statistics</h2>
            <p class="text-gray-600 text-sm mb-4">These can be adjusted based on your class and species bonuses</p>

            <!-- Ability Scores -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                @php
                    $abilities = [
                        'strength' => 'Strength',
                        'dexterity' => 'Dexterity',
                        'constitution' => 'Constitution',
                        'intelligence' => 'Intelligence',
                        'wisdom' => 'Wisdom',
                        'charisma' => 'Charisma',
                    ];
                @endphp
                @foreach ($abilities as $key => $label)
                    <div>
                        <label for="abilities_{{ $key }}" class="block text-sm font-semibold text-gray-700 mb-2">
                            {{ $label }}
                        </label>
                        <input
                            type="number"
                            id="abilities_{{ $key }}"
                            name="abilityScores[{{ $key }}]"
                            value="{{ old('abilityScores.' . $key, 10) }}"
                            min="3"
                            max="20"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 text-center"
                        />
                    </div>
                @endforeach
            </div>

            <!-- Hit Points and Level -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="level" class="block text-sm font-semibold text-gray-700 mb-2">
                        Starting Level
                    </label>
                    <input
                        type="number"
                        id="level"
                        name="level"
                        value="{{ old('level', 1) }}"
                        min="1"
                        max="20"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                    />
                </div>

                <div>
                    <label for="maxHitPoints" class="block text-sm font-semibold text-gray-700 mb-2">
                        Max Hit Points
                    </label>
                    <input
                        type="number"
                        id="maxHitPoints"
                        name="maxHitPoints"
                        value="{{ old('maxHitPoints') }}"
                        min="1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                    />
                </div>

                <div>
                    <label for="armorClass" class="block text-sm font-semibold text-gray-700 mb-2">
                        Armor Class
                    </label>
                    <input
                        type="number"
                        id="armorClass"
                        name="armorClass"
                        value="{{ old('armorClass', 10) }}"
                        min="1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"
                    />
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center space-x-4 pt-4">
            <button
                type="submit"
                class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-8 rounded-lg transition"
            >
                Create Character
            </button>
            <a
                href="{{ route('characters.index') }}"
                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-8 rounded-lg transition"
            >
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
