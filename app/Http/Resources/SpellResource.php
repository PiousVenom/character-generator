<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read \App\Models\Spell $resource
 */
final class SpellResource extends JsonResource
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
            'level' => $this->resource->level,
            'school' => $this->resource->school,
            'castingTime' => $this->resource->casting_time,
            'range' => $this->resource->range,
            'components' => $this->resource->components,
            'duration' => $this->resource->duration,
            'concentration' => $this->resource->concentration,
            'ritual' => $this->resource->ritual,
            'isPrepared' => $this->resource->pivot->is_prepared ?? null,
        ];
    }
}
