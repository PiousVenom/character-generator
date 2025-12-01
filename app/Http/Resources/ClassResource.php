<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform CharacterClass model to camelCase API response.
 *
 * @property \App\Models\CharacterClass $resource
 */
final class ClassResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                       => $this->resource->id,
            'name'                     => $this->resource->name,
            'slug'                     => $this->resource->slug,
            'description'              => $this->resource->description,
            'hitDie'                   => $this->resource->hit_die,
            'primaryAbilities'         => $this->resource->primary_abilities,
            'savingThrowProficiencies' => $this->resource->saving_throw_proficiencies,
            'armorProficiencies'       => $this->resource->armor_proficiencies,
            'weaponProficiencies'      => $this->resource->weapon_proficiencies,
            'toolProficiencies'        => $this->resource->tool_proficiencies,
            'skillChoices'             => $this->resource->skill_choices,
            'startingEquipment'        => $this->resource->starting_equipment,
            'spellcastingAbility'      => $this->resource->spellcasting_ability,
            'subclassLevel'            => $this->resource->subclass_level,
            'subclasses'               => SubclassResource::collection($this->whenLoaded('subclasses')),
            'features'                 => ClassFeatureResource::collection($this->whenLoaded('features')),
        ];
    }
}
