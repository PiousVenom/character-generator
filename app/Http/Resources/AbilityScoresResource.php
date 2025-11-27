<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read \App\Models\AbilityScore $resource
 */
final class AbilityScoresResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'characterId' => $this->resource->character_id,
            'strength' => $this->resource->strength,
            'dexterity' => $this->resource->dexterity,
            'constitution' => $this->resource->constitution,
            'intelligence' => $this->resource->intelligence,
            'wisdom' => $this->resource->wisdom,
            'charisma' => $this->resource->charisma,
            'strengthModifier' => $this->resource->strength_modifier,
            'dexterityModifier' => $this->resource->dexterity_modifier,
            'constitutionModifier' => $this->resource->constitution_modifier,
            'intelligenceModifier' => $this->resource->intelligence_modifier,
            'wisdomModifier' => $this->resource->wisdom_modifier,
            'charismaModifier' => $this->resource->charisma_modifier,
        ];
    }
}
