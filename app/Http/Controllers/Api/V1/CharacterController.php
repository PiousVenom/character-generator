<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Models\Character;
use App\Services\CharacterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use function is_array;
use function is_string;

/**
 * Handles Character CRUD operations.
 *
 * All business logic delegated to CharacterService.
 */
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
            data: $characters->items(),
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
    public function show(Request $request, Character $character): JsonResponse
    {
        $include  = $request->query('include', '');
        $includes = $this->parseIncludes(is_string($include) ? $include : '');
        $character->load($includes);

        return $this->successResponse(
            data: $character,
            message: 'Character retrieved successfully',
        );
    }

    /**
     * Create a new character.
     *
     * POST /api/v1/characters
     */
    public function store(Request $request): JsonResponse
    {
        // Validation will be handled by Form Request in DEV-02-form-requests
        // For now, accept validated data directly
        /** @var array<string, mixed> $validated */
        $validated = $request->all();

        $character = $this->characterService->create($validated);

        return $this->createdResponse(
            data: $character,
            message: 'Character created successfully',
        );
    }

    /**
     * Update a character (partial or full).
     *
     * PUT/PATCH /api/v1/characters/{uuid}
     */
    public function update(Request $request, Character $character): JsonResponse
    {
        // Validation will be handled by Form Request in DEV-02-form-requests
        /** @var array<string, mixed> $validated */
        $validated = $request->all();

        $character = $this->characterService->update($character, $validated);

        return $this->successResponse(
            data: $character,
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
