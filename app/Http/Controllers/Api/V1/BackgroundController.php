<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\BackgroundResource;
use App\Models\Background;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class BackgroundController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $backgrounds = Background::query()
            ->orderBy('name')
            ->get();

        return $this->successResponse(
            BackgroundResource::collection($backgrounds),
            'Backgrounds retrieved successfully',
        );
    }

    public function show(Background $background): JsonResponse
    {
        return $this->successResponse(
            new BackgroundResource($background),
            'Background retrieved successfully',
        );
    }
}
