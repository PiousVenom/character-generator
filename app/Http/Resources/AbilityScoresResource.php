<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform AbilityScore model to camelCase API response.
 *
 * Includes computed modifier values for each ability.
 *
 * @property \App\Models\AbilityScore $resource
 */
final class AbilityScoresResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'strength'             => $this->resource->strength,
            'strengthModifier'     => $this->resource->strength_modifier,
            'dexterity'            => $this->resource->dexterity,
            'dexterityModifier'    => $this->resource->dexterity_modifier,
            'constitution'         => $this->resource->constitution,
            'constitutionModifier' => $this->resource->constitution_modifier,
            'intelligence'         => $this->resource->intelligence,
            'intelligenceModifier' => $this->resource->intelligence_modifier,
            'wisdom'               => $this->resource->wisdom,
            'wisdomModifier'       => $this->resource->wisdom_modifier,
            'charisma'             => $this->resource->charisma,
            'charismaModifier'     => $this->resource->charisma_modifier,
        ];
    }
}
