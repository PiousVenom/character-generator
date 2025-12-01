<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\SpeciesResource;
use App\Models\Species;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function min;

/**
 * Read-only controller for species reference data.
 */
final class SpeciesController extends Controller
{
    /**
     * List all species.
     *
     * GET /api/v1/species
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min((int) $request->query('perPage', 15), 100);

        /** @phpstan-ignore staticMethod.dynamicCall */
        $species = Species::query()
            ->orderBy('name')
            ->paginate($perPage);

        return $this->successResponse(
            data: SpeciesResource::collection($species->items()),
            message: 'Species retrieved successfully',
            additionalMeta: [
                'pagination' => [
                    'currentPage' => $species->currentPage(),
                    'perPage'     => $species->perPage(),
                    'total'       => $species->total(),
                    'lastPage'    => $species->lastPage(),
                ],
            ],
        );
    }

    /**
     * Get species details with all traits.
     *
     * GET /api/v1/species/{uuid}
     */
    public function show(Species $species): JsonResponse
    {
        return $this->successResponse(
            data: new SpeciesResource($species),
            message: 'Species retrieved successfully',
        );
    }
}
