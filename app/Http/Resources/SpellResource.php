<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform Spell model to camelCase API response.
 *
 * @property \App\Models\Spell $resource
 */
final class SpellResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->resource->id,
            'name'          => $this->resource->name,
            'slug'          => $this->resource->slug,
            'description'   => $this->resource->description,
            'level'         => $this->resource->level,
            'school'        => $this->resource->school,
            'castingTime'   => $this->resource->casting_time,
            'range'         => $this->resource->range,
            'components'    => [
                'verbal'           => $this->resource->components_verbal,
                'somatic'          => $this->resource->components_somatic,
                'material'         => $this->resource->components_material,
                'materialCost'     => $this->resource->components_material_cost,
                'materialConsumed' => $this->resource->components_material_consumed,
            ],
            'duration'      => $this->resource->duration,
            'concentration' => $this->resource->concentration,
            'ritual'        => $this->resource->ritual,
            'higherLevels'  => $this->resource->higher_levels,
            'isCantrip'     => $this->resource->is_cantrip,
            /* @phpstan-ignore property.notFound, property.nonObject */
            'prepared'      => $this->whenPivotLoaded('character_spells', fn () => (bool) $this->resource->pivot->prepared),
            /* @phpstan-ignore property.notFound, property.nonObject */
            'source'        => $this->whenPivotLoaded('character_spells', fn () => $this->resource->pivot->source),
        ];
    }
}
