@extends('layouts.app')

@section('title', $character->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $character->name }}</h1>
            <p class="text-gray-600 mt-2">
                {{ $character->class?->name ?? 'Unknown Class' }} • Level {{ $character->level }} •
                {{ $character->species?->name ?? 'Unknown Species' }}
            </p>
        </div>
        <div class="space-x-4">
            <a href="{{ route('characters.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-2 px-6 rounded-lg transition">
                Back to Characters
            </a>
            <a href="#" class="bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-6 rounded-lg transition">
                Edit Character
            </a>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Core Stats -->
        <div class="lg:col-span-1">
            <!-- Hit Points Card -->
            <div class="bg-white rounded-lg shadow p-6 mb-6 border-l-4 border-red-500">
                <h3 class="text-sm font-semibold text-gray-600 mb-2">HIT POINTS</h3>
                <div class="flex items-baseline space-x-2">
                    <span class="text-4xl font-bold text-red-600">{{ $character->current_hit_points ?? '—' }}</span>
                    <span class="text-xl text-gray-500">/</span>
                    <span class="text-2xl text-gray-600">{{ $character->max_hit_points ?? '—' }}</span>
                </div>
                @if ($character->temporary_hit_points > 0)
                    <p class="text-sm text-gray-600 mt-2">Temporary: {{ $character->temporary_hit_points }}</p>
                @endif
            </div>

            <!-- Core Stats Card -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Core Statistics</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                        <span class="text-gray-600">Armor Class</span>
                        <span class="text-2xl font-bold text-blue-600">{{ $character->armor_class ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                        <span class="text-gray-600">Initiative</span>
                        <span class="text-xl font-semibold">{{ $character->initiative_bonus ?? '—' }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                        <span class="text-gray-600">Speed</span>
                        <span class="text-xl font-semibold">{{ $character->speed ?? '—' }} ft</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-600">Proficiency Bonus</span>
                        <span class="text-xl font-semibold text-green-600">+{{ $character->proficiency_bonus ?? '—' }}</span>
                    </div>
                </div>
            </div>

            <!-- Character Info Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Character Information</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <p class="text-gray-600">Class</p>
                        <p class="font-semibold">{{ $character->class?->name ?? 'Unknown' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Species</p>
                        <p class="font-semibold">{{ $character->species?->name ?? 'Unknown' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Background</p>
                        <p class="font-semibold">{{ $character->background?->name ?? 'None' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Alignment</p>
                        <p class="font-semibold">{{ $character->alignment?->value ?? 'Unknown' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Experience Points</p>
                        <p class="font-semibold">{{ number_format($character->experience_points ?? 0) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Inspiration</p>
                        <p class="font-semibold">{{ $character->inspiration ? 'Yes' : 'No' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Ability Scores and Details -->
        <div class="lg:col-span-2">
            <!-- Ability Scores Card -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Ability Scores</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @php
                        $abilities = [
                            'Strength' => 'str',
                            'Dexterity' => 'dex',
                            'Constitution' => 'con',
                            'Intelligence' => 'int',
                            'Wisdom' => 'wis',
                            'Charisma' => 'cha',
                        ];
                    @endphp
                    @foreach ($abilities as $abilityName => $abbr)
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded p-4 text-center">
                            <p class="text-xs font-semibold text-gray-600 mb-2">{{ $abilityName }}</p>
                            <p class="text-3xl font-bold text-gray-900 mb-1">
                                {{ $character->abilityScores?->{"base_{$abbr}"} ?? '—' }}
                            </p>
                            @php
                                $score = $character->abilityScores?->{"base_{$abbr}"};
                                $modifier = $score ? (int) floor(($score - 10) / 2) : 0;
                                $modifierStr = $modifier >= 0 ? "+{$modifier}" : "{$modifier}";
                            @endphp
                            <p class="text-sm font-semibold {{ $modifier >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $modifierStr }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Skills and Proficiencies Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Skills Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Skills</h3>
                    @if ($character->skills->isEmpty())
                        <p class="text-gray-600 text-sm">No skills assigned</p>
                    @else
                        <div class="space-y-2">
                            @foreach ($character->skills as $skill)
                                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $skill->name }}</p>
                                        <p class="text-xs text-gray-600">Ability: {{ $skill->ability_type ?? 'N/A' }}</p>
                                    </div>
                                    @php
                                        $proficient = $skill->pivot->is_proficient ? '+' : '';
                                        $expertise = $skill->pivot->has_expertise ? ' (Expertise)' : '';
                                    @endphp
                                    <span class="font-semibold text-purple-600">{{ $proficient }}{{ $skill->pivot->is_proficient ? 'Prof.' : '—' }}{{ $expertise }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Spells Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Spells</h3>
                    @if ($character->spells->isEmpty())
                        <p class="text-gray-600 text-sm">No spells known</p>
                    @else
                        <div class="space-y-2">
                            @foreach ($character->spells as $spell)
                                <div class="flex items-center justify-between py-2 border-b border-gray-200">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $spell->name }}</p>
                                        <p class="text-xs text-gray-600">Level {{ $spell->level }}</p>
                                    </div>
                                    @if ($spell->pivot->is_prepared)
                                        <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Prepared</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Equipment Card -->
            <div class="bg-white rounded-lg shadow p-6 mt-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Equipment</h3>
                @if ($character->equipment->isEmpty())
                    <p class="text-gray-600 text-sm">No equipment assigned</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-900">Name</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-900">Quantity</th>
                                    <th class="px-4 py-2 text-left font-semibold text-gray-900">Equipped</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($character->equipment as $item)
                                    <tr>
                                        <td class="px-4 py-2 text-gray-900">{{ $item->name }}</td>
                                        <td class="px-4 py-2 text-gray-600">{{ $item->pivot->quantity }}</td>
                                        <td class="px-4 py-2">
                                            @if ($item->pivot->is_equipped)
                                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">Equipped</span>
                                            @else
                                                <span class="text-xs text-gray-500">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
