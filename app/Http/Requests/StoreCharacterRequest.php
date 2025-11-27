<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\Alignment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class StoreCharacterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:1', 'max:255'],
            'classId' => ['required', 'uuid', 'exists:classes,id'],
            'speciesId' => ['required', 'uuid', 'exists:species,id'],
            'backgroundId' => ['required', 'uuid', 'exists:backgrounds,id'],
            'alignment' => ['required', Rule::enum(Alignment::class)],
            'abilityScores' => ['required', 'array'],
            'abilityScores.strength' => ['required', 'integer', 'min:3', 'max:18'],
            'abilityScores.dexterity' => ['required', 'integer', 'min:3', 'max:18'],
            'abilityScores.constitution' => ['required', 'integer', 'min:3', 'max:18'],
            'abilityScores.intelligence' => ['required', 'integer', 'min:3', 'max:18'],
            'abilityScores.wisdom' => ['required', 'integer', 'min:3', 'max:18'],
            'abilityScores.charisma' => ['required', 'integer', 'min:3', 'max:18'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'classId.exists' => 'The selected class does not exist.',
            'speciesId.exists' => 'The selected species does not exist.',
            'backgroundId.exists' => 'The selected background does not exist.',
            'abilityScores.strength.min' => 'Strength must be at least 3.',
            'abilityScores.strength.max' => 'Strength cannot exceed 18 (before racial modifiers).',
        ];
    }

    /**
     * Convert camelCase input keys to snake_case for model.
     *
     * @return array<string, mixed>
     */
    public function forModel(): array
    {
        return [
            'name' => $this->input('name'),
            'class_id' => $this->input('classId'),
            'species_id' => $this->input('speciesId'),
            'background_id' => $this->input('backgroundId'),
            'alignment' => $this->input('alignment'),
        ];
    }

    /**
     * @return array{strength: int, dexterity: int, constitution: int, intelligence: int, wisdom: int, charisma: int}
     */
    public function abilityScores(): array
    {
        $validated = $this->validated();

        /** @var array{strength: int, dexterity: int, constitution: int, intelligence: int, wisdom: int, charisma: int} $scores */
        $scores = $validated['abilityScores'];

        return $scores;
    }
}
