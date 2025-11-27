<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read \App\Models\ClassFeature $resource
 */
final class ClassFeatureResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'classId' => $this->resource->class_id,
            'subclassId' => $this->resource->subclass_id,
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'levelAcquired' => $this->resource->level_acquired ?? null,
        ];
    }
}
