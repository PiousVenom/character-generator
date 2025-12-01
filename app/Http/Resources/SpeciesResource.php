<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform Species model to camelCase API response.
 *
 * @property \App\Models\Species $resource
 */
final class SpeciesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->resource->id,
            'name'                => $this->resource->name,
            'slug'                => $this->resource->slug,
            'description'         => $this->resource->description,
            'size'                => $this->resource->size,
            'speed'               => $this->resource->speed,
            'creatureType'        => $this->resource->creature_type,
            'darkvision'          => $this->resource->darkvision,
            'traits'              => $this->resource->traits,
            'languages'           => $this->resource->languages,
            'abilityScoreOptions' => $this->resource->ability_score_options,
            'hasLineageChoice'    => $this->resource->has_lineage_choice,
            'lineages'            => $this->resource->lineages,
        ];
    }
}
