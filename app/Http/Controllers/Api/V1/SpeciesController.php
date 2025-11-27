<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\SpeciesResource;
use App\Models\Species;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class SpeciesController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $species = Species::query()
            ->orderBy('name')
            ->get();

        return $this->successResponse(
            SpeciesResource::collection($species),
            'Species retrieved successfully',
        );
    }

    public function show(Species $species): JsonResponse
    {
        return $this->successResponse(
            new SpeciesResource($species),
            'Species retrieved successfully',
        );
    }
}
