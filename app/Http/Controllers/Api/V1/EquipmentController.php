<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class EquipmentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = min((int) $request->query('perPage', 50), 100);

        $equipment = Equipment::query()
            ->orderBy('name')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => EquipmentResource::collection($equipment),
            'message' => 'Equipment retrieved successfully',
            'meta' => array_merge(
                ['timestamp' => now()->toIso8601String(), 'version' => 'v1'],
                // @phpstan-ignore-next-line - Paginator template types are not covariant
                $this->getPaginationMeta($equipment),
            ),
            // @phpstan-ignore-next-line - Paginator template types are not covariant
            'links' => $this->getPaginationLinks($equipment),
        ]);
    }

    public function show(Equipment $equipment): JsonResponse
    {
        return $this->successResponse(
            new EquipmentResource($equipment),
            'Equipment retrieved successfully',
        );
    }
}
