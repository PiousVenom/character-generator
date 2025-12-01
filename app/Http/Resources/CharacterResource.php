<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform Character model to camelCase API response.
 *
 * @property \App\Models\Character $resource
 */
final class CharacterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                 => $this->resource->id,
            'name'               => $this->resource->name,
            'level'              => $this->resource->level,
            'experiencePoints'   => $this->resource->experience_points,
            'maxHitPoints'       => $this->resource->max_hit_points,
            'currentHitPoints'   => $this->resource->current_hit_points,
            'temporaryHitPoints' => $this->resource->temporary_hit_points,
            'armorClass'         => $this->resource->armor_class,
            'initiativeBonus'    => $this->resource->initiative_bonus,
            'speed'              => $this->resource->speed,
            'proficiencyBonus'   => $this->resource->proficiency_bonus,
            'inspiration'        => $this->resource->inspiration,
            'alignment'          => $this->resource->alignment,
            'personalityTraits'  => $this->resource->personality_traits,
            'ideals'             => $this->resource->ideals,
            'bonds'              => $this->resource->bonds,
            'flaws'              => $this->resource->flaws,
            'backstory'          => $this->resource->backstory,
            'notes'              => $this->resource->notes,
            'class'              => new ClassResource($this->whenLoaded('class')),
            'species'            => new SpeciesResource($this->whenLoaded('species')),
            'background'         => new BackgroundResource($this->whenLoaded('background')),
            'abilityScores'      => new AbilityScoresResource($this->whenLoaded('abilityScores')),
            'skills'             => SkillResource::collection($this->whenLoaded('skills')),
            'equipment'          => EquipmentResource::collection($this->whenLoaded('equipment')),
            'spells'             => SpellResource::collection($this->whenLoaded('spells')),
            'feats'              => FeatResource::collection($this->whenLoaded('feats')),
            'createdAt'          => $this->resource->created_at?->toIso8601String(),
            'updatedAt'          => $this->resource->updated_at?->toIso8601String(),
        ];
    }
}
