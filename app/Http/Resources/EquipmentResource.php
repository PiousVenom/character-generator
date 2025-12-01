<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform Equipment model to camelCase API response.
 *
 * @property \App\Models\Equipment $resource
 */
final class EquipmentResource extends JsonResource
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
            'equipmentType'       => $this->resource->equipment_type,
            'equipmentSubtype'    => $this->resource->equipment_subtype,
            'costCp'              => $this->resource->cost_cp,
            'weightLb'            => $this->resource->weight_lb,
            'damageDice'          => $this->resource->damage_dice,
            'damageType'          => $this->resource->damage_type,
            'properties'          => $this->resource->properties,
            'armorClass'          => $this->resource->armor_class,
            'armorDexCap'         => $this->resource->armor_dex_cap,
            'strengthRequirement' => $this->resource->strength_requirement,
            'stealthDisadvantage' => $this->resource->stealth_disadvantage,
            'rangeNormal'         => $this->resource->range_normal,
            'rangeLong'           => $this->resource->range_long,
            /* @phpstan-ignore property.notFound, property.nonObject */
            'quantity'            => $this->whenPivotLoaded('character_equipment', fn () => $this->resource->pivot->quantity),
            /* @phpstan-ignore property.notFound, property.nonObject */
            'equipped'            => $this->whenPivotLoaded('character_equipment', fn () => (bool) $this->resource->pivot->equipped),
            /* @phpstan-ignore property.notFound, property.nonObject */
            'attuned'             => $this->whenPivotLoaded('character_equipment', fn () => (bool) $this->resource->pivot->attuned),
        ];
    }
}
