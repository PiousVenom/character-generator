<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

// Home page
Route::get('/', static fn () => view('home'))->name('home');

// Character routes (placeholder for Phase 3)
Route::prefix('characters')->name('characters.')->group(static function (): void {
    Route::get('/', static fn () => view('characters.index'))->name('index');
    Route::get('/create', static fn () => view('characters.create'))->name('create');
    Route::get('/{character}', static fn (string $character) => view('characters.show', ['character' => $character]))->name('show');
    Route::get('/{character}/edit', static fn (string $character) => view('characters.edit', ['character' => $character]))->name('edit');
});
