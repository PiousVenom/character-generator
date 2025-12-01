<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Models\Background;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function min;

/**
 * Read-only controller for background reference data.
 */
final class BackgroundController extends Controller
{
    /**
     * List all backgrounds.
     *
     * GET /api/v1/backgrounds
     */
    public function index(Request $request): JsonResponse
    {
        $perPage = min((int) $request->query('perPage', 15), 100);

        /** @phpstan-ignore staticMethod.dynamicCall */
        $backgrounds = Background::query()
            ->orderBy('name')
            ->paginate($perPage);

        return $this->successResponse(
            data: $backgrounds->items(),
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
    public function show(Background $background): JsonResponse
    {
        return $this->successResponse(
            data: $background,
            message: 'Background retrieved successfully',
        );
    }
}
