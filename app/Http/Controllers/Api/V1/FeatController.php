<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\FeatResource;
use App\Models\Feat;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class FeatController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $feats = Feat::query()
            ->orderBy('name')
            ->get();

        return $this->successResponse(
            FeatResource::collection($feats),
            'Feats retrieved successfully',
        );
    }

    public function show(Feat $feat): JsonResponse
    {
        return $this->successResponse(
            new FeatResource($feat),
            'Feat retrieved successfully',
        );
    }
}
