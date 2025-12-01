<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\ClassResource;
use App\Models\CharacterClass;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

use function is_string;
use function min;

/**
 * Read-only controller for class reference data.
 */
#[OA\Schema(
    schema: 'Class',
    properties: [
        new OA\Property(property: 'id', type: 'string', format: 'uuid'),
        new OA\Property(property: 'name', type: 'string', example: 'Fighter'),
        new OA\Property(property: 'slug', type: 'string', example: 'fighter'),
        new OA\Property(property: 'description', type: 'string'),
        new OA\Property(property: 'hitDie', type: 'integer', example: 10),
        new OA\Property(property: 'primaryAbilities', type: 'array', items: new OA\Items(type: 'string')),
        new OA\Property(property: 'savingThrowProficiencies', type: 'array', items: new OA\Items(type: 'string')),
        new OA\Property(property: 'armorProficiencies', type: 'array', items: new OA\Items(type: 'string')),
        new OA\Property(property: 'weaponProficiencies', type: 'array', items: new OA\Items(type: 'string')),
        new OA\Property(property: 'toolProficiencies', type: 'array', items: new OA\Items(type: 'string'), nullable: true),
        new OA\Property(property: 'skillChoices', type: 'object'),
        new OA\Property(property: 'startingEquipment', type: 'object'),
        new OA\Property(property: 'spellcastingAbility', type: 'string', nullable: true),
        new OA\Property(property: 'subclassLevel', type: 'integer', example: 3),
        new OA\Property(property: 'subclasses', type: 'array', items: new OA\Items(ref: '#/components/schemas/Subclass')),
        new OA\Property(property: 'features', type: 'array', items: new OA\Items(ref: '#/components/schemas/ClassFeature')),
    ],
)]
#[OA\Schema(
    schema: 'Subclass',
    properties: [
        new OA\Property(property: 'id', type: 'string', format: 'uuid'),
        new OA\Property(property: 'name', type: 'string', example: 'Champion'),
        new OA\Property(property: 'slug', type: 'string', example: 'champion'),
        new OA\Property(property: 'description', type: 'string'),
    ],
)]
#[OA\Schema(
    schema: 'ClassFeature',
    properties: [
        new OA\Property(property: 'id', type: 'string', format: 'uuid'),
        new OA\Property(property: 'name', type: 'string', example: 'Second Wind'),
        new OA\Property(property: 'level', type: 'integer', example: 1),
        new OA\Property(property: 'description', type: 'string'),
    ],
)]
final class ClassController extends Controller
{
    /**
     * List all classes with optional filtering.
     *
     * GET /api/v1/classes
     */
    #[OA\Get(
        path: '/classes',
        summary: 'List all classes',
        description: 'Returns a paginated list of D&D character classes.',
        tags: ['Classes'],
        parameters: [
            new OA\Parameter(name: 'page', in: 'query', description: 'Page number', schema: new OA\Schema(type: 'integer', default: 1)),
            new OA\Parameter(name: 'perPage', in: 'query', description: 'Items per page (max 100)', schema: new OA\Schema(type: 'integer', default: 15, maximum: 100)),
            new OA\Parameter(name: 'filter.spellcaster', in: 'query', description: 'Filter to only spellcasting classes', schema: new OA\Schema(type: 'string', enum: ['true'])),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Classes retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Class')),
                        new OA\Property(property: 'message', type: 'string', example: 'Classes retrieved successfully'),
                    ],
                ),
            ),
        ],
    )]
    public function index(Request $request): JsonResponse
    {
        $query = CharacterClass::query();

        // Optional filtering for spellcasting classes
        $filterSpellcaster = $request->query('filter.spellcaster');

        if ($filterSpellcaster !== null && $filterSpellcaster === 'true') {
            /* @phpstan-ignore staticMethod.dynamicCall */
            $query->whereNotNull('spellcasting_ability');
        }

        $perPage = min((int) $request->query('perPage', 15), 100);

        /** @phpstan-ignore staticMethod.dynamicCall */
        $classes = $query->orderBy('name')->paginate($perPage);

        return $this->successResponse(
            data: ClassResource::collection($classes->items()),
            message: 'Classes retrieved successfully',
            additionalMeta: [
                'pagination' => [
                    'currentPage' => $classes->currentPage(),
                    'perPage'     => $classes->perPage(),
                    'total'       => $classes->total(),
                    'lastPage'    => $classes->lastPage(),
                ],
            ],
        );
    }

    /**
     * Get class details with features.
     *
     * GET /api/v1/classes/{uuid}
     */
    #[OA\Get(
        path: '/classes/{id}',
        summary: 'Get a class',
        description: 'Returns detailed information about a D&D class including subclasses and features.',
        tags: ['Classes'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Class UUID',
                schema: new OA\Schema(type: 'string', format: 'uuid'),
            ),
            new OA\Parameter(name: 'include', in: 'query', description: 'Include features', schema: new OA\Schema(type: 'string', example: 'features')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Class retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'data', ref: '#/components/schemas/Class'),
                        new OA\Property(property: 'message', type: 'string', example: 'Class retrieved successfully'),
                    ],
                ),
            ),
            new OA\Response(response: 404, description: 'Class not found', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse')),
        ],
    )]
    public function show(Request $request, CharacterClass $class): JsonResponse
    {
        $include = $request->query('include', '');

        // Default load features and subclasses
        $includes = ['subclasses'];

        if (is_string($include) && str_contains($include, 'features')) {
            $includes[] = 'features';
        } else {
            // Always include features for class details
            $includes[] = 'features';
        }

        $class->load($includes);

        return $this->successResponse(
            data: new ClassResource($class),
            message: 'Class retrieved successfully',
        );
    }
}
