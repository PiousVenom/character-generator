<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform Background model to camelCase API response.
 *
 * @property \App\Models\Background $resource
 */
final class BackgroundResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                     => $this->resource->id,
            'name'                   => $this->resource->name,
            'slug'                   => $this->resource->slug,
            'description'            => $this->resource->description,
            'skillProficiencies'     => $this->resource->skill_proficiencies,
            'toolProficiency'        => $this->resource->tool_proficiency,
            'toolProficiencyChoices' => $this->resource->tool_proficiency_choices,
            'startingEquipment'      => $this->resource->starting_equipment,
            'startingGold'           => $this->resource->starting_gold,
            'originFeat'             => $this->whenLoaded('originFeat', fn () => new FeatResource($this->resource->originFeat)),
            'featureName'            => $this->resource->feature_name,
            'featureDescription'     => $this->resource->feature_description,
        ];
    }
}
