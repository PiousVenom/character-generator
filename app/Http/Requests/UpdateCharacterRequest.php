<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\Alignment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateCharacterRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'min:1', 'max:255'],
            'classId' => ['sometimes', 'uuid', 'exists:classes,id'],
            'speciesId' => ['sometimes', 'uuid', 'exists:species,id'],
            'backgroundId' => ['sometimes', 'uuid', 'exists:backgrounds,id'],
            'subclassId' => ['sometimes', 'nullable', 'uuid', 'exists:subclasses,id'],
            'alignment' => ['sometimes', Rule::enum(Alignment::class)],
            'level' => ['sometimes', 'integer', 'min:1', 'max:20'],
            'experiencePoints' => ['sometimes', 'integer', 'min:0'],
            'maxHitPoints' => ['sometimes', 'integer', 'min:1'],
            'currentHitPoints' => ['sometimes', 'integer', 'min:0'],
            'temporaryHitPoints' => ['sometimes', 'integer', 'min:0'],
            'armorClass' => ['sometimes', 'integer', 'min:1'],
            'initiativeBonus' => ['sometimes', 'integer'],
            'speed' => ['sometimes', 'integer', 'min:0'],
            'proficiencyBonus' => ['sometimes', 'integer', 'min:2'],
            'inspiration' => ['sometimes', 'boolean'],
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
            'subclassId.exists' => 'The selected subclass does not exist.',
            'level.max' => 'Character level cannot exceed 20.',
        ];
    }

    /**
     * Convert camelCase input to snake_case for model.
     *
     * @return array<string, mixed>
     */
    public function forModel(): array
    {
        $data = [];

        if ($this->has('name')) {
            $data['name'] = $this->input('name');
        }

        if ($this->has('classId')) {
            $data['class_id'] = $this->input('classId');
        }

        if ($this->has('speciesId')) {
            $data['species_id'] = $this->input('speciesId');
        }

        if ($this->has('backgroundId')) {
            $data['background_id'] = $this->input('backgroundId');
        }

        if ($this->has('subclassId')) {
            $data['subclass_id'] = $this->input('subclassId');
        }

        if ($this->has('alignment')) {
            $data['alignment'] = $this->input('alignment');
        }

        if ($this->has('level')) {
            $data['level'] = $this->input('level');
        }

        if ($this->has('experiencePoints')) {
            $data['experience_points'] = $this->input('experiencePoints');
        }

        if ($this->has('maxHitPoints')) {
            $data['max_hit_points'] = $this->input('maxHitPoints');
        }

        if ($this->has('currentHitPoints')) {
            $data['current_hit_points'] = $this->input('currentHitPoints');
        }

        if ($this->has('temporaryHitPoints')) {
            $data['temporary_hit_points'] = $this->input('temporaryHitPoints');
        }

        if ($this->has('armorClass')) {
            $data['armor_class'] = $this->input('armorClass');
        }

        if ($this->has('initiativeBonus')) {
            $data['initiative_bonus'] = $this->input('initiativeBonus');
        }

        if ($this->has('speed')) {
            $data['speed'] = $this->input('speed');
        }

        if ($this->has('proficiencyBonus')) {
            $data['proficiency_bonus'] = $this->input('proficiencyBonus');
        }

        if ($this->has('inspiration')) {
            $data['inspiration'] = $this->input('inspiration');
        }

        return $data;
    }
}
