<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Character;
use Illuminate\View\View;

final class CharacterController extends Controller
{
    /**
     * Display a listing of characters.
     */
    public function index(): View
    {
        $characters = Character::with([
            'class',
            'species',
            'background',
        ])->get();

        return view('characters.index', [
            'characters' => $characters,
        ]);
    }

    /**
     * Show the form for creating a new character.
     */
    public function create(): View
    {
        return view('characters.create');
    }

    /**
     * Display the specified character.
     *
     * @param string $id Character UUID
     */
    public function show(string $id): View
    {
        $character = Character::with([
            'class',
            'species',
            'background',
            'subclass',
            'abilityScores',
            'skills',
            'equipment',
            'spells',
        ])->findOrFail($id);

        return view('characters.show', [
            'character' => $character,
        ]);
    }
}
