<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\SpellResource;
use App\Models\Spell;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class SpellController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = min((int) $request->query('perPage', 50), 100);

        $spells = Spell::query()
            ->orderBy('level')
            ->orderBy('name')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => SpellResource::collection($spells),
            'message' => 'Spells retrieved successfully',
            'meta' => array_merge(
                ['timestamp' => now()->toIso8601String(), 'version' => 'v1'],
                // @phpstan-ignore-next-line - Paginator template types are not covariant
                $this->getPaginationMeta($spells),
            ),
            // @phpstan-ignore-next-line - Paginator template types are not covariant
            'links' => $this->getPaginationLinks($spells),
        ]);
    }

    public function show(Spell $spell): JsonResponse
    {
        return $this->successResponse(
            new SpellResource($spell),
            'Spell retrieved successfully',
        );
    }
}
