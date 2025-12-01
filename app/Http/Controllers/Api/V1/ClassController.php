<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Models\CharacterClass;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use function is_string;
use function min;

/**
 * Read-only controller for class reference data.
 */
final class ClassController extends Controller
{
    /**
     * List all classes with optional filtering.
     *
     * GET /api/v1/classes
     */
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
            data: $classes->items(),
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
            data: $class,
            message: 'Class retrieved successfully',
        );
    }
}
