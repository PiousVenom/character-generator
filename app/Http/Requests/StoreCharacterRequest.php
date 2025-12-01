<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\Alignment;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;

/**
 * Validation for creating a new character.
 *
 * Accepts camelCase input from API and provides forModel()
 * to transform to snake_case for database operations.
 */
final class StoreCharacterRequest extends FormRequest
{
    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'classId'                    => 'class',
            'speciesId'                  => 'species',
            'backgroundId'               => 'background',
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
            'name.required'                       => 'Character name is required.',
            'name.max'                            => 'Character name cannot exceed 255 characters.',
            'classId.required'                    => 'Class selection is required.',
            'classId.uuid'                        => 'Invalid class ID format.',
            'classId.exists'                      => 'The selected class does not exist.',
            'speciesId.required'                  => 'Species selection is required.',
            'speciesId.uuid'                      => 'Invalid species ID format.',
            'speciesId.exists'                    => 'The selected species does not exist.',
            'backgroundId.required'               => 'Background selection is required.',
            'backgroundId.uuid'                   => 'Invalid background ID format.',
            'backgroundId.exists'                 => 'The selected background does not exist.',
            'abilityScores.required'              => 'Ability scores are required.',
            'abilityScores.strength.required'     => 'Strength score is required.',
            'abilityScores.strength.min'          => 'Strength must be at least 3.',
            'abilityScores.strength.max'          => 'Strength cannot exceed 18.',
            'abilityScores.dexterity.required'    => 'Dexterity score is required.',
            'abilityScores.dexterity.min'         => 'Dexterity must be at least 3.',
            'abilityScores.dexterity.max'         => 'Dexterity cannot exceed 18.',
            'abilityScores.constitution.required' => 'Constitution score is required.',
            'abilityScores.constitution.min'      => 'Constitution must be at least 3.',
            'abilityScores.constitution.max'      => 'Constitution cannot exceed 18.',
            'abilityScores.intelligence.required' => 'Intelligence score is required.',
            'abilityScores.intelligence.min'      => 'Intelligence must be at least 3.',
            'abilityScores.intelligence.max'      => 'Intelligence cannot exceed 18.',
            'abilityScores.wisdom.required'       => 'Wisdom score is required.',
            'abilityScores.wisdom.min'            => 'Wisdom must be at least 3.',
            'abilityScores.wisdom.max'            => 'Wisdom cannot exceed 18.',
            'abilityScores.charisma.required'     => 'Charisma score is required.',
            'abilityScores.charisma.min'          => 'Charisma must be at least 3.',
            'abilityScores.charisma.max'          => 'Charisma cannot exceed 18.',
            'alignment.in'                        => 'Invalid alignment value.',
            'backstory.max'                       => 'Backstory cannot exceed 10000 characters.',
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
            'name'                       => ['required', 'string', 'max:255'],
            'classId'                    => ['required', 'uuid', 'exists:classes,id'],
            'speciesId'                  => ['required', 'uuid', 'exists:species,id'],
            'backgroundId'               => ['required', 'uuid', 'exists:backgrounds,id'],
            'abilityScores'              => ['required', 'array'],
            'abilityScores.strength'     => ['required', 'integer', 'min:3', 'max:18'],
            'abilityScores.dexterity'    => ['required', 'integer', 'min:3', 'max:18'],
            'abilityScores.constitution' => ['required', 'integer', 'min:3', 'max:18'],
            'abilityScores.intelligence' => ['required', 'integer', 'min:3', 'max:18'],
            'abilityScores.wisdom'       => ['required', 'integer', 'min:3', 'max:18'],
            'abilityScores.charisma'     => ['required', 'integer', 'min:3', 'max:18'],
            'alignment'                  => ['nullable', 'string', Rule::in(Alignment::values())],
            'personalityTraits'          => ['nullable', 'string', 'max:1000'],
            'ideals'                     => ['nullable', 'string', 'max:1000'],
            'bonds'                      => ['nullable', 'string', 'max:1000'],
            'flaws'                      => ['nullable', 'string', 'max:1000'],
            'backstory'                  => ['nullable', 'string', 'max:10000'],
        ];
    }
}
