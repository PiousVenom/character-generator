<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read \App\Models\Species $resource
 */
final class SpeciesResource extends JsonResource
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
            'size' => $this->resource->size,
            'speed' => $this->resource->speed,
            'abilityScoreIncreases' => $this->resource->ability_score_increases,
            'languages' => $this->resource->languages,
            'traits' => $this->resource->traits,
        ];
    }
}
