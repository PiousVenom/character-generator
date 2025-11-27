<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\BackgroundController;
use App\Http\Controllers\Api\V1\CharacterController;
use App\Http\Controllers\Api\V1\ClassController;
use App\Http\Controllers\Api\V1\EquipmentController;
use App\Http\Controllers\Api\V1\FeatController;
use App\Http\Controllers\Api\V1\SpeciesController;
use App\Http\Controllers\Api\V1\SpellController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Characters - Full CRUD
    Route::apiResource('characters', CharacterController::class);

    // Reference Data - Read Only
    Route::apiResource('classes', ClassController::class)->only(['index', 'show']);
    Route::apiResource('species', SpeciesController::class)->only(['index', 'show']);
    Route::apiResource('backgrounds', BackgroundController::class)->only(['index', 'show']);
    Route::apiResource('equipment', EquipmentController::class)->only(['index', 'show']);
    Route::apiResource('spells', SpellController::class)->only(['index', 'show']);
    Route::apiResource('feats', FeatController::class)->only(['index', 'show']);
});

// Health check (outside versioning)
Route::get('health', function () {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now()->toIso8601String(),
    ]);
});
