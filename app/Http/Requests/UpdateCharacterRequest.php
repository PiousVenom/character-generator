<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\Alignment;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;

/**
 * Validation for updating a character.
 *
 * All fields are optional for partial updates.
 * Uses 'sometimes' rule to only validate fields that are present.
 */
final class UpdateCharacterRequest extends FormRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'abilityScores.strength'     => 'strength',
            'abilityScores.dexterity'    => 'dexterity',
            'abilityScores.constitution' => 'constitution',
            'abilityScores.intelligence' => 'intelligence',
            'abilityScores.wisdom'       => 'wisdom',
            'abilityScores.charisma'     => 'charisma',
            'personalityTraits'          => 'personality traits',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): true
    {
        // No auth yet - will be updated when auth is implemented
        return true;
    }

    /**
     * Get custom error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.max'                            => 'Character name cannot exceed 255 characters.',
            'abilityScores.strength.min'          => 'Strength must be at least 3.',
            'abilityScores.strength.max'          => 'Strength cannot exceed 18.',
            'abilityScores.dexterity.min'         => 'Dexterity must be at least 3.',
            'abilityScores.dexterity.max'         => 'Dexterity cannot exceed 18.',
            'abilityScores.constitution.min'      => 'Constitution must be at least 3.',
            'abilityScores.constitution.max'      => 'Constitution cannot exceed 18.',
            'abilityScores.intelligence.min'      => 'Intelligence must be at least 3.',
            'abilityScores.intelligence.max'      => 'Intelligence cannot exceed 18.',
            'abilityScores.wisdom.min'            => 'Wisdom must be at least 3.',
            'abilityScores.wisdom.max'            => 'Wisdom cannot exceed 18.',
            'abilityScores.charisma.min'          => 'Charisma must be at least 3.',
            'abilityScores.charisma.max'          => 'Charisma cannot exceed 18.',
            'alignment.in'                        => 'Invalid alignment value.',
            'backstory.max'                       => 'Backstory cannot exceed 10000 characters.',
            'notes.max'                           => 'Notes cannot exceed 10000 characters.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, ValidationRule|In|string>>
     */
    public function rules(): array
    {
        return [
            'name'                       => ['sometimes', 'string', 'max:255'],
            'abilityScores'              => ['sometimes', 'array'],
            'abilityScores.strength'     => ['sometimes', 'integer', 'min:3', 'max:18'],
            'abilityScores.dexterity'    => ['sometimes', 'integer', 'min:3', 'max:18'],
            'abilityScores.constitution' => ['sometimes', 'integer', 'min:3', 'max:18'],
            'abilityScores.intelligence' => ['sometimes', 'integer', 'min:3', 'max:18'],
            'abilityScores.wisdom'       => ['sometimes', 'integer', 'min:3', 'max:18'],
            'abilityScores.charisma'     => ['sometimes', 'integer', 'min:3', 'max:18'],
            'alignment'                  => ['sometimes', 'nullable', 'string', Rule::in(Alignment::values())],
            'personalityTraits'          => ['sometimes', 'nullable', 'string', 'max:1000'],
            'ideals'                     => ['sometimes', 'nullable', 'string', 'max:1000'],
            'bonds'                      => ['sometimes', 'nullable', 'string', 'max:1000'],
            'flaws'                      => ['sometimes', 'nullable', 'string', 'max:1000'],
            'backstory'                  => ['sometimes', 'nullable', 'string', 'max:10000'],
            'notes'                      => ['sometimes', 'nullable', 'string', 'max:10000'],
        ];
    }
}
