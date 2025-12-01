<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform Feat model to camelCase API response.
 *
 * @property \App\Models\Feat $resource
 */
final class FeatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                   => $this->resource->id,
            'name'                 => $this->resource->name,
            'slug'                 => $this->resource->slug,
            'description'          => $this->resource->description,
            'category'             => $this->resource->category,
            'levelRequirement'     => $this->resource->level_requirement,
            'prerequisites'        => $this->resource->prerequisites,
            'benefits'             => $this->resource->benefits,
            'abilityScoreIncrease' => $this->resource->ability_score_increase,
            'repeatable'           => $this->resource->repeatable,
            'isOriginFeat'         => $this->resource->is_origin_feat,
            /* @phpstan-ignore property.notFound, property.nonObject */
            'source'               => $this->whenPivotLoaded('character_feats', fn () => $this->resource->pivot->source),
            /* @phpstan-ignore property.notFound, property.nonObject */
            'choices'              => $this->whenPivotLoaded('character_feats', fn () => $this->resource->pivot->choices),
        ];
    }
}
