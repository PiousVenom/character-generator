<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read \App\Models\CharacterClass $resource
 */
final class ClassResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'hitDie' => $this->resource->hit_die,
            'primaryAbility' => $this->resource->primary_ability,
            'savingThrowProficiencies' => $this->resource->saving_throw_proficiencies,
            'armorProficiencies' => $this->resource->armor_proficiencies,
            'weaponProficiencies' => $this->resource->weapon_proficiencies,
            'toolProficiencies' => $this->resource->tool_proficiencies,
            'skillChoicesCount' => $this->resource->skill_choices_count,
            'skillChoicesList' => $this->resource->skill_choices_list,
            'spellcastingAbility' => $this->resource->spellcasting_ability,
            'features' => ClassFeatureResource::collection($this->whenLoaded('features')),
            'subclasses' => SubclassResource::collection($this->whenLoaded('subclasses')),
        ];
    }
}
