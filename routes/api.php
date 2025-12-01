<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\CharacterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
| Middleware applied to all routes (configured in bootstrap/app.php):
| - CorrelationId (X-Correlation-ID header)
| - RequestLogging (audit trail)
|
*/

Route::prefix('v1')->group(static function (): void {
    /*
    |--------------------------------------------------------------------------
    | Health Check
    |--------------------------------------------------------------------------
    */
    Route::get('health', static fn (): array => [
        'status'    => 'ok',
        'timestamp' => now()->toIso8601String(),
        'version'   => 'v1',
    ])->name('api.v1.health');

    /*
    |--------------------------------------------------------------------------
    | Character CRUD
    |--------------------------------------------------------------------------
    */
    Route::apiResource('characters', CharacterController::class);

    /*
    |--------------------------------------------------------------------------
    | Reference Data (Read-Only)
    |--------------------------------------------------------------------------
    |
    | Reference data endpoints for character creation options.
    | Routes will be enabled when controllers are implemented.
    |
    */
    // Route::apiResource('classes', ClassController::class)->only(['index', 'show']);
    // Route::apiResource('species', SpeciesController::class)->only(['index', 'show']);
    // Route::apiResource('backgrounds', BackgroundController::class)->only(['index', 'show']);
    // Route::apiResource('equipment', EquipmentController::class)->only(['index', 'show']);
    // Route::apiResource('spells', SpellController::class)->only(['index', 'show']);
    // Route::apiResource('feats', FeatController::class)->only(['index', 'show']);
});
