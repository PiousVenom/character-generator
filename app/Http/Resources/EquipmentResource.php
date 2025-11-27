<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read \App\Models\Equipment $resource
 */
final class EquipmentResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'type' => $this->resource->type,
            'description' => $this->resource->description,
            'costCopper' => $this->resource->cost_copper,
            'weight' => $this->resource->weight,
            'properties' => $this->resource->properties,
            'weaponProperties' => $this->resource->weapon_properties,
            'armorProperties' => $this->resource->armor_properties,
            'requiresAttunement' => $this->resource->requires_attunement,
            'quantity' => $this->resource->pivot->quantity ?? null,
            'isEquipped' => $this->resource->pivot->is_equipped ?? null,
            'isAttuned' => $this->resource->pivot->is_attuned ?? null,
        ];
    }
}
