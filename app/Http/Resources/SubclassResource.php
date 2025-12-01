<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform Subclass model to camelCase API response.
 *
 * @property \App\Models\Subclass $resource
 */
final class SubclassResource extends JsonResource
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
            'source'      => $this->resource->source,
            'features'    => ClassFeatureResource::collection($this->whenLoaded('features')),
        ];
    }
}
