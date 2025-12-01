<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\SpeciesResource;
use App\Models\Species;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

use function min;

/**
 * Read-only controller for species reference data.
 */
#[OA\Schema(
    schema: 'Species',
    properties: [
        new OA\Property(property: 'id', type: 'string', format: 'uuid'),
        new OA\Property(property: 'name', type: 'string', example: 'Human'),
        new OA\Property(property: 'slug', type: 'string', example: 'human'),
        new OA\Property(property: 'description', type: 'string'),
        new OA\Property(property: 'size', type: 'string', example: 'Medium'),
        new OA\Property(property: 'speed', type: 'integer', example: 30),
        new OA\Property(property: 'creatureType', type: 'string', example: 'Humanoid'),
        new OA\Property(property: 'darkvision', type: 'integer', nullable: true, example: 60),
        new OA\Property(property: 'traits', type: 'array', items: new OA\Items(type: 'object')),
        new OA\Property(property: 'languages', type: 'array', items: new OA\Items(type: 'string')),
        new OA\Property(property: 'abilityScoreOptions', type: 'object'),
        new OA\Property(property: 'hasLineageChoice', type: 'boolean'),
        new OA\Property(property: 'lineages', type: 'array', items: new OA\Items(type: 'object'), nullable: true),
    ],
)]
final class SpeciesController extends Controller
{
    /**
     * List all species.
     *
     * GET /api/v1/species
     */
    #[OA\Get(
        path: '/species',
        summary: 'List all species',
        description: 'Returns a paginated list of D&D character species.',
        tags: ['Species'],
        parameters: [
            new OA\Parameter(name: 'page', in: 'query', description: 'Page number', schema: new OA\Schema(type: 'integer', default: 1)),
            new OA\Parameter(name: 'perPage', in: 'query', description: 'Items per page (max 100)', schema: new OA\Schema(type: 'integer', default: 15, maximum: 100)),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Species retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Species')),
                        new OA\Property(property: 'message', type: 'string', example: 'Species retrieved successfully'),
                    ],
                ),
            ),
        ],
    )]
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
    #[OA\Get(
        path: '/species/{id}',
        summary: 'Get a species',
        description: 'Returns detailed information about a D&D species including traits.',
        tags: ['Species'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Species UUID',
                schema: new OA\Schema(type: 'string', format: 'uuid'),
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Species retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'data', ref: '#/components/schemas/Species'),
                        new OA\Property(property: 'message', type: 'string', example: 'Species retrieved successfully'),
                    ],
                ),
            ),
            new OA\Response(response: 404, description: 'Species not found', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse')),
        ],
    )]
    public function show(Species $species): JsonResponse
    {
        return $this->successResponse(
            data: new SpeciesResource($species),
            message: 'Species retrieved successfully',
        );
    }
}
