<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read \App\Models\Character $resource
 */
final class CharacterResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'level' => $this->resource->level,
            'experiencePoints' => $this->resource->experience_points,
            'alignment' => $this->resource->alignment,
            'maxHitPoints' => $this->resource->max_hit_points,
            'currentHitPoints' => $this->resource->current_hit_points,
            'temporaryHitPoints' => $this->resource->temporary_hit_points,
            'armorClass' => $this->resource->armor_class,
            'initiativeBonus' => $this->resource->initiative_bonus,
            'speed' => $this->resource->speed,
            'proficiencyBonus' => $this->resource->proficiency_bonus,
            'inspiration' => $this->resource->inspiration,
            'classId' => $this->resource->class_id,
            'speciesId' => $this->resource->species_id,
            'backgroundId' => $this->resource->background_id,
            'subclassId' => $this->resource->subclass_id,
            'class' => new ClassResource($this->whenLoaded('characterClass')),
            'species' => new SpeciesResource($this->whenLoaded('species')),
            'background' => new BackgroundResource($this->whenLoaded('background')),
            'subclass' => new SubclassResource($this->whenLoaded('subclass')),
            'abilityScores' => new AbilityScoresResource($this->whenLoaded('abilityScores')),
            'skills' => SkillResource::collection($this->whenLoaded('skills')),
            'equipment' => EquipmentResource::collection($this->whenLoaded('equipment')),
            'spells' => SpellResource::collection($this->whenLoaded('spells')),
            'feats' => FeatResource::collection($this->whenLoaded('feats')),
            'createdAt' => $this->resource->created_at?->toIso8601String(),
            'updatedAt' => $this->resource->updated_at?->toIso8601String(),
        ];
    }
}
