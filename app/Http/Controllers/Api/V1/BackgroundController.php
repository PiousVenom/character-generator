<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\BackgroundResource;
use App\Models\Background;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

use function min;

/**
 * Read-only controller for background reference data.
 */
#[OA\Schema(
    schema: 'Background',
    properties: [
        new OA\Property(property: 'id', type: 'string', format: 'uuid'),
        new OA\Property(property: 'name', type: 'string', example: 'Acolyte'),
        new OA\Property(property: 'slug', type: 'string', example: 'acolyte'),
        new OA\Property(property: 'description', type: 'string'),
        new OA\Property(property: 'skillProficiencies', type: 'array', items: new OA\Items(type: 'string')),
        new OA\Property(property: 'toolProficiency', type: 'string', nullable: true),
        new OA\Property(property: 'toolProficiencyChoices', type: 'array', items: new OA\Items(type: 'string'), nullable: true),
        new OA\Property(property: 'startingEquipment', type: 'object'),
        new OA\Property(property: 'startingGold', type: 'integer', example: 15),
        new OA\Property(property: 'originFeat', ref: '#/components/schemas/Feat', nullable: true),
        new OA\Property(property: 'featureName', type: 'string', example: 'Shelter of the Faithful'),
        new OA\Property(property: 'featureDescription', type: 'string'),
    ],
)]
#[OA\Schema(
    schema: 'Feat',
    properties: [
        new OA\Property(property: 'id', type: 'string', format: 'uuid'),
        new OA\Property(property: 'name', type: 'string', example: 'Alert'),
        new OA\Property(property: 'description', type: 'string'),
        new OA\Property(property: 'prerequisite', type: 'string', nullable: true),
        new OA\Property(property: 'category', type: 'string', example: 'General'),
    ],
)]
final class BackgroundController extends Controller
{
    /**
     * List all backgrounds.
     *
     * GET /api/v1/backgrounds
     */
    #[OA\Get(
        path: '/backgrounds',
        summary: 'List all backgrounds',
        description: 'Returns a paginated list of D&D character backgrounds.',
        tags: ['Backgrounds'],
        parameters: [
            new OA\Parameter(name: 'page', in: 'query', description: 'Page number', schema: new OA\Schema(type: 'integer', default: 1)),
            new OA\Parameter(name: 'perPage', in: 'query', description: 'Items per page (max 100)', schema: new OA\Schema(type: 'integer', default: 15, maximum: 100)),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Backgrounds retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Background')),
                        new OA\Property(property: 'message', type: 'string', example: 'Backgrounds retrieved successfully'),
                    ],
                ),
            ),
        ],
    )]
    public function index(Request $request): JsonResponse
    {
        $perPage = min((int) $request->query('perPage', 15), 100);

        /** @phpstan-ignore staticMethod.dynamicCall */
        $backgrounds = Background::query()
            ->orderBy('name')
            ->paginate($perPage);

        return $this->successResponse(
            data: BackgroundResource::collection($backgrounds->items()),
            message: 'Backgrounds retrieved successfully',
            additionalMeta: [
                'pagination' => [
                    'currentPage' => $backgrounds->currentPage(),
                    'perPage'     => $backgrounds->perPage(),
                    'total'       => $backgrounds->total(),
                    'lastPage'    => $backgrounds->lastPage(),
                ],
            ],
        );
    }

    /**
     * Get background details.
     *
     * GET /api/v1/backgrounds/{uuid}
     */
    #[OA\Get(
        path: '/backgrounds/{id}',
        summary: 'Get a background',
        description: 'Returns detailed information about a D&D background.',
        tags: ['Backgrounds'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Background UUID',
                schema: new OA\Schema(type: 'string', format: 'uuid'),
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Background retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'data', ref: '#/components/schemas/Background'),
                        new OA\Property(property: 'message', type: 'string', example: 'Background retrieved successfully'),
                    ],
                ),
            ),
            new OA\Response(response: 404, description: 'Background not found', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse')),
        ],
    )]
    public function show(Background $background): JsonResponse
    {
        return $this->successResponse(
            data: new BackgroundResource($background),
            message: 'Background retrieved successfully',
        );
    }
}
