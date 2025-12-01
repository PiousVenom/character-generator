<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreCharacterRequest;
use App\Http\Requests\UpdateCharacterRequest;
use App\Http\Resources\CharacterResource;
use App\Models\Character;
use App\Services\CharacterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

use function is_array;
use function is_string;

/**
 * Handles Character CRUD operations.
 *
 * All business logic delegated to CharacterService.
 */
#[OA\Schema(
    schema: 'Character',
    required: ['id', 'name', 'level'],
    properties: [
        new OA\Property(property: 'id', type: 'string', format: 'uuid'),
        new OA\Property(property: 'name', type: 'string', example: 'Gandalf the Grey'),
        new OA\Property(property: 'level', type: 'integer', example: 1),
        new OA\Property(property: 'experiencePoints', type: 'integer', example: 0),
        new OA\Property(property: 'maxHitPoints', type: 'integer', example: 10),
        new OA\Property(property: 'currentHitPoints', type: 'integer', example: 10),
        new OA\Property(property: 'temporaryHitPoints', type: 'integer', example: 0),
        new OA\Property(property: 'armorClass', type: 'integer', example: 10),
        new OA\Property(property: 'initiativeBonus', type: 'integer', example: 2),
        new OA\Property(property: 'speed', type: 'integer', example: 30),
        new OA\Property(property: 'proficiencyBonus', type: 'integer', example: 2),
        new OA\Property(property: 'inspiration', type: 'boolean', example: false),
        new OA\Property(property: 'alignment', type: 'string', enum: ['lawful_good', 'neutral_good', 'chaotic_good', 'lawful_neutral', 'true_neutral', 'chaotic_neutral', 'lawful_evil', 'neutral_evil', 'chaotic_evil'], nullable: true),
        new OA\Property(property: 'personalityTraits', type: 'string', nullable: true),
        new OA\Property(property: 'ideals', type: 'string', nullable: true),
        new OA\Property(property: 'bonds', type: 'string', nullable: true),
        new OA\Property(property: 'flaws', type: 'string', nullable: true),
        new OA\Property(property: 'backstory', type: 'string', nullable: true),
        new OA\Property(property: 'notes', type: 'string', nullable: true),
        new OA\Property(property: 'class', ref: '#/components/schemas/Class', nullable: true),
        new OA\Property(property: 'species', ref: '#/components/schemas/Species', nullable: true),
        new OA\Property(property: 'background', ref: '#/components/schemas/Background', nullable: true),
        new OA\Property(property: 'abilityScores', ref: '#/components/schemas/AbilityScores', nullable: true),
        new OA\Property(property: 'createdAt', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updatedAt', type: 'string', format: 'date-time'),
    ],
)]
#[OA\Schema(
    schema: 'AbilityScores',
    properties: [
        new OA\Property(property: 'strength', type: 'integer', minimum: 1, maximum: 30, example: 10),
        new OA\Property(property: 'strengthModifier', type: 'integer', example: 0),
        new OA\Property(property: 'dexterity', type: 'integer', minimum: 1, maximum: 30, example: 14),
        new OA\Property(property: 'dexterityModifier', type: 'integer', example: 2),
        new OA\Property(property: 'constitution', type: 'integer', minimum: 1, maximum: 30, example: 12),
        new OA\Property(property: 'constitutionModifier', type: 'integer', example: 1),
        new OA\Property(property: 'intelligence', type: 'integer', minimum: 1, maximum: 30, example: 16),
        new OA\Property(property: 'intelligenceModifier', type: 'integer', example: 3),
        new OA\Property(property: 'wisdom', type: 'integer', minimum: 1, maximum: 30, example: 13),
        new OA\Property(property: 'wisdomModifier', type: 'integer', example: 1),
        new OA\Property(property: 'charisma', type: 'integer', minimum: 1, maximum: 30, example: 8),
        new OA\Property(property: 'charismaModifier', type: 'integer', example: -1),
    ],
)]
#[OA\Schema(
    schema: 'CreateCharacterRequest',
    required: ['name', 'classId', 'speciesId', 'backgroundId', 'abilityScores'],
    properties: [
        new OA\Property(property: 'name', type: 'string', maxLength: 255, example: 'Thorin Ironforge'),
        new OA\Property(property: 'classId', type: 'string', format: 'uuid'),
        new OA\Property(property: 'speciesId', type: 'string', format: 'uuid'),
        new OA\Property(property: 'backgroundId', type: 'string', format: 'uuid'),
        new OA\Property(
            property: 'abilityScores',
            type: 'object',
            required: ['strength', 'dexterity', 'constitution', 'intelligence', 'wisdom', 'charisma'],
            properties: [
                new OA\Property(property: 'strength', type: 'integer', minimum: 3, maximum: 18, example: 16),
                new OA\Property(property: 'dexterity', type: 'integer', minimum: 3, maximum: 18, example: 12),
                new OA\Property(property: 'constitution', type: 'integer', minimum: 3, maximum: 18, example: 14),
                new OA\Property(property: 'intelligence', type: 'integer', minimum: 3, maximum: 18, example: 10),
                new OA\Property(property: 'wisdom', type: 'integer', minimum: 3, maximum: 18, example: 13),
                new OA\Property(property: 'charisma', type: 'integer', minimum: 3, maximum: 18, example: 8),
            ],
        ),
        new OA\Property(property: 'alignment', type: 'string', enum: ['lawful_good', 'neutral_good', 'chaotic_good', 'lawful_neutral', 'true_neutral', 'chaotic_neutral', 'lawful_evil', 'neutral_evil', 'chaotic_evil'], nullable: true),
        new OA\Property(property: 'personalityTraits', type: 'string', maxLength: 1000, nullable: true),
        new OA\Property(property: 'ideals', type: 'string', maxLength: 1000, nullable: true),
        new OA\Property(property: 'bonds', type: 'string', maxLength: 1000, nullable: true),
        new OA\Property(property: 'flaws', type: 'string', maxLength: 1000, nullable: true),
        new OA\Property(property: 'backstory', type: 'string', maxLength: 10000, nullable: true),
    ],
)]
#[OA\Schema(
    schema: 'UpdateCharacterRequest',
    properties: [
        new OA\Property(property: 'name', type: 'string', maxLength: 255),
        new OA\Property(
            property: 'abilityScores',
            type: 'object',
            properties: [
                new OA\Property(property: 'strength', type: 'integer', minimum: 3, maximum: 18),
                new OA\Property(property: 'dexterity', type: 'integer', minimum: 3, maximum: 18),
                new OA\Property(property: 'constitution', type: 'integer', minimum: 3, maximum: 18),
                new OA\Property(property: 'intelligence', type: 'integer', minimum: 3, maximum: 18),
                new OA\Property(property: 'wisdom', type: 'integer', minimum: 3, maximum: 18),
                new OA\Property(property: 'charisma', type: 'integer', minimum: 3, maximum: 18),
            ],
        ),
        new OA\Property(property: 'alignment', type: 'string', enum: ['lawful_good', 'neutral_good', 'chaotic_good', 'lawful_neutral', 'true_neutral', 'chaotic_neutral', 'lawful_evil', 'neutral_evil', 'chaotic_evil'], nullable: true),
        new OA\Property(property: 'personalityTraits', type: 'string', maxLength: 1000, nullable: true),
        new OA\Property(property: 'ideals', type: 'string', maxLength: 1000, nullable: true),
        new OA\Property(property: 'bonds', type: 'string', maxLength: 1000, nullable: true),
        new OA\Property(property: 'flaws', type: 'string', maxLength: 1000, nullable: true),
        new OA\Property(property: 'backstory', type: 'string', maxLength: 10000, nullable: true),
        new OA\Property(property: 'notes', type: 'string', maxLength: 10000, nullable: true),
    ],
)]
final class CharacterController extends Controller
{
    public function __construct(
        private readonly CharacterService $characterService,
    ) {
    }

    /**
     * Soft delete a character.
     *
     * DELETE /api/v1/characters/{uuid}
     */
    #[OA\Delete(
        path: '/characters/{id}',
        summary: 'Delete a character',
        description: 'Soft deletes a character. The character is not permanently removed and can potentially be restored.',
        tags: ['Characters'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Character UUID',
                schema: new OA\Schema(type: 'string', format: 'uuid'),
            ),
        ],
        responses: [
            new OA\Response(response: 204, description: 'Character deleted successfully'),
            new OA\Response(response: 404, description: 'Character not found', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse')),
        ],
    )]
    public function destroy(Character $character): JsonResponse
    {
        $this->characterService->delete($character);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * List characters with pagination.
     *
     * GET /api/v1/characters
     * Query params: page, perPage, filter[], sort, include
     */
    #[OA\Get(
        path: '/characters',
        summary: 'List all characters',
        description: 'Returns a paginated list of characters with optional filtering, sorting, and relationship includes.',
        tags: ['Characters'],
        parameters: [
            new OA\Parameter(name: 'page', in: 'query', description: 'Page number', schema: new OA\Schema(type: 'integer', default: 1)),
            new OA\Parameter(name: 'perPage', in: 'query', description: 'Items per page (max 100)', schema: new OA\Schema(type: 'integer', default: 15, maximum: 100)),
            new OA\Parameter(name: 'filter[classId]', in: 'query', description: 'Filter by class UUID', schema: new OA\Schema(type: 'string', format: 'uuid')),
            new OA\Parameter(name: 'filter[speciesId]', in: 'query', description: 'Filter by species UUID', schema: new OA\Schema(type: 'string', format: 'uuid')),
            new OA\Parameter(name: 'filter[minLevel]', in: 'query', description: 'Minimum character level', schema: new OA\Schema(type: 'integer', minimum: 1)),
            new OA\Parameter(name: 'filter[maxLevel]', in: 'query', description: 'Maximum character level', schema: new OA\Schema(type: 'integer', maximum: 20)),
            new OA\Parameter(name: 'sort', in: 'query', description: 'Sort field (prefix with - for descending)', schema: new OA\Schema(type: 'string', default: '-createdAt', enum: ['name', '-name', 'level', '-level', 'createdAt', '-createdAt', 'updatedAt', '-updatedAt'])),
            new OA\Parameter(name: 'include', in: 'query', description: 'Comma-separated relationships to include', schema: new OA\Schema(type: 'string', example: 'class,species,abilityScores')),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Characters retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'data', type: 'array', items: new OA\Items(ref: '#/components/schemas/Character')),
                        new OA\Property(property: 'message', type: 'string', example: 'Characters retrieved successfully'),
                        new OA\Property(
                            property: 'meta',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'timestamp', type: 'string', format: 'date-time'),
                                new OA\Property(property: 'version', type: 'string', example: 'v1'),
                                new OA\Property(property: 'pagination', ref: '#/components/schemas/PaginationMeta'),
                            ],
                        ),
                    ],
                ),
            ),
        ],
    )]
    public function index(Request $request): JsonResponse
    {
        $filters = $request->query('filter');
        $sort    = $request->query('sort', '-createdAt');
        $include = $request->query('include', '');
        $perPage = min((int) $request->query('perPage', 15), 100);

        /** @var array<string, mixed> $filterArray */
        $filterArray = is_array($filters) ? $filters : [];

        $characters = $this->characterService->list(
            filters: $filterArray,
            sort: is_string($sort) ? $sort : '-createdAt',
            includes: is_string($include) ? $include : '',
            perPage: $perPage,
        );

        return $this->successResponse(
            data: CharacterResource::collection($characters->items()),
            message: 'Characters retrieved successfully',
            additionalMeta: [
                'pagination' => [
                    'currentPage' => $characters->currentPage(),
                    'perPage'     => $characters->perPage(),
                    'total'       => $characters->total(),
                    'lastPage'    => $characters->lastPage(),
                ],
            ],
        );
    }

    /**
     * Get a single character with relationships.
     *
     * GET /api/v1/characters/{uuid}
     * Query params: include
     */
    #[OA\Get(
        path: '/characters/{id}',
        summary: 'Get a character',
        description: 'Returns a single character with optional relationship includes.',
        tags: ['Characters'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Character UUID',
                schema: new OA\Schema(type: 'string', format: 'uuid'),
            ),
            new OA\Parameter(
                name: 'include',
                in: 'query',
                description: 'Comma-separated relationships to include',
                schema: new OA\Schema(type: 'string', example: 'class,species,background,abilityScores'),
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Character retrieved successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'data', ref: '#/components/schemas/Character'),
                        new OA\Property(property: 'message', type: 'string', example: 'Character retrieved successfully'),
                    ],
                ),
            ),
            new OA\Response(response: 404, description: 'Character not found', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse')),
        ],
    )]
    public function show(Request $request, Character $character): JsonResponse
    {
        $include  = $request->query('include', '');
        $includes = $this->parseIncludes(is_string($include) ? $include : '');
        $character->load($includes);

        return $this->successResponse(
            data: new CharacterResource($character),
            message: 'Character retrieved successfully',
        );
    }

    /**
     * Create a new character.
     *
     * POST /api/v1/characters
     */
    #[OA\Post(
        path: '/characters',
        summary: 'Create a new character',
        description: 'Creates a new D&D character with the provided details. Ability scores must be between 3-18 for character creation.',
        tags: ['Characters'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/CreateCharacterRequest'),
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Character created successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'data', ref: '#/components/schemas/Character'),
                        new OA\Property(property: 'message', type: 'string', example: 'Character created successfully'),
                    ],
                ),
            ),
            new OA\Response(response: 422, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse')),
        ],
    )]
    public function store(StoreCharacterRequest $request): JsonResponse
    {
        /** @var array<string, mixed> $validated */
        $validated = $request->validated();

        $character = $this->characterService->create($validated);

        return $this->createdResponse(
            data: new CharacterResource($character),
            message: 'Character created successfully',
        );
    }

    /**
     * Update a character (partial or full).
     *
     * PUT/PATCH /api/v1/characters/{uuid}
     */
    #[OA\Patch(
        path: '/characters/{id}',
        summary: 'Update a character',
        description: 'Partially updates a character. Only include fields you want to change.',
        tags: ['Characters'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                description: 'Character UUID',
                schema: new OA\Schema(type: 'string', format: 'uuid'),
            ),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/UpdateCharacterRequest'),
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Character updated successfully',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'data', ref: '#/components/schemas/Character'),
                        new OA\Property(property: 'message', type: 'string', example: 'Character updated successfully'),
                    ],
                ),
            ),
            new OA\Response(response: 404, description: 'Character not found', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse')),
            new OA\Response(response: 422, description: 'Validation error', content: new OA\JsonContent(ref: '#/components/schemas/ErrorResponse')),
        ],
    )]
    public function update(UpdateCharacterRequest $request, Character $character): JsonResponse
    {
        /** @var array<string, mixed> $validated */
        $validated = $request->validated();

        $character = $this->characterService->update($character, $validated);

        return $this->successResponse(
            data: new CharacterResource($character),
            message: 'Character updated successfully',
        );
    }

    /**
     * Parse and validate include relationships.
     *
     * @return array<string>
     */
    private function parseIncludes(string $includes): array
    {
        if ($includes === '') {
            return ['class', 'species', 'background', 'abilityScores'];
        }

        $allowedIncludes = [
            'class',
            'class.features',
            'species',
            'background',
            'abilityScores',
            'skills',
            'equipment',
            'spells',
            'feats',
        ];

        return array_intersect(
            explode(',', $includes),
            $allowedIncludes,
        );
    }
}
