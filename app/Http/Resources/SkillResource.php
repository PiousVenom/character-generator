<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform Skill model to camelCase API response.
 *
 * @property \App\Models\Skill $resource
 */
final class SkillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->resource->id,
            'name'        => $this->resource->name,
            'slug'        => $this->resource->slug,
            'description' => $this->resource->description,
            'ability'     => $this->resource->ability,
            /* @phpstan-ignore property.notFound, property.nonObject */
            'proficient'  => $this->whenPivotLoaded('character_skills', fn () => (bool) $this->resource->pivot->proficient),
            /* @phpstan-ignore property.notFound, property.nonObject */
            'expertise'   => $this->whenPivotLoaded('character_skills', fn () => (bool) $this->resource->pivot->expertise),
        ];
    }
}
