<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read \App\Models\Background $resource
 */
final class BackgroundResource extends JsonResource
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
            'skillProficiencies' => $this->resource->skill_proficiencies,
            'toolProficiencies' => $this->resource->tool_proficiencies,
            'languages' => $this->resource->languages,
            'startingEquipment' => $this->resource->starting_equipment,
            'featureName' => $this->resource->feature_name,
            'featureDescription' => $this->resource->feature_description,
        ];
    }
}
