<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read \App\Models\Subclass $resource
 */
final class SubclassResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'classId' => $this->resource->class_id,
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'features' => ClassFeatureResource::collection($this->whenLoaded('features')),
        ];
    }
}
