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
use Symfony\Component\HttpFoundation\Response;

final class CharacterController extends Controller
{
    public function __construct(
        private readonly CharacterService $characterService,
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $perPage = min((int) $request->query('perPage', 15), 100);

        $characters = Character::query()
            ->with(['characterClass', 'species', 'background'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => CharacterResource::collection($characters),
            'message' => 'Characters retrieved successfully',
            'meta' => array_merge(
                ['timestamp' => now()->toIso8601String(), 'version' => 'v1'],
                // @phpstan-ignore-next-line - Paginator template types are not covariant
                $this->getPaginationMeta($characters),
            ),
            // @phpstan-ignore-next-line - Paginator template types are not covariant
            'links' => $this->getPaginationLinks($characters),
        ]);
    }

    public function store(StoreCharacterRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // @phpstan-ignore-next-line - Type narrowing from validated() is complex
        $character = $this->characterService->create([
            'name' => $validated['name'],
            'classId' => $validated['classId'],
            'speciesId' => $validated['speciesId'],
            'backgroundId' => $validated['backgroundId'],
            'alignment' => $validated['alignment'],
            'abilityScores' => $request->abilityScores(),
        ]);

        return $this->successResponse(
            new CharacterResource($character),
            'Character created successfully',
            Response::HTTP_CREATED,
        );
    }

    public function show(Character $character): JsonResponse
    {
        $character->load([
            'characterClass.features',
            'species',
            'background',
            'subclass',
            'abilityScores',
            'skills',
            'equipment',
            'spells',
            'feats',
        ]);

        return $this->successResponse(
            new CharacterResource($character),
            'Character retrieved successfully',
        );
    }

    public function update(UpdateCharacterRequest $request, Character $character): JsonResponse
    {
        $character = $this->characterService->update($character, $request->forModel());

        return $this->successResponse(
            new CharacterResource($character),
            'Character updated successfully',
        );
    }

    public function destroy(Character $character): JsonResponse
    {
        $this->characterService->delete($character);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
