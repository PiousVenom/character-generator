<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read \App\Models\Skill $resource
 */
final class SkillResource extends JsonResource
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
            'ability' => $this->resource->ability,
            'isProficient' => $this->resource->pivot->is_proficient ?? null,
            'hasExpertise' => $this->resource->pivot->has_expertise ?? null,
        ];
    }
}
