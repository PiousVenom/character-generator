<?php

declare(strict_types=1);

use App\Http\Controllers\Web\CharacterController;
use Illuminate\Support\Facades\Route;

// Welcome page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Character routes
Route::resource('characters', CharacterController::class)->only(['index', 'create', 'show']);
