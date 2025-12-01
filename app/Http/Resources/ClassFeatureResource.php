<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Transform ClassFeature model to camelCase API response.
 *
 * @property \App\Models\ClassFeature $resource
 */
final class ClassFeatureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->resource->id,
            'name'              => $this->resource->name,
            'description'       => $this->resource->description,
            'level'             => $this->resource->level,
            'isSubclassFeature' => $this->resource->is_subclass_feature,
        ];
    }
}
