<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\ClassResource;
use App\Models\CharacterClass;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ClassController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $classes = CharacterClass::query()
            ->orderBy('name')
            ->get();

        return $this->successResponse(
            ClassResource::collection($classes),
            'Classes retrieved successfully',
        );
    }

    public function show(CharacterClass $class): JsonResponse
    {
        $class->load(['features', 'subclasses']);

        return $this->successResponse(
            new ClassResource($class),
            'Class retrieved successfully',
        );
    }
}
