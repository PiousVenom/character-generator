<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SpellSchool;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Spell extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    /**
     * Disable auto-incrementing for UUID.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Primary key type for UUID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'level',
        'school',
        'casting_time',
        'range',
        'components',
        'duration',
        'concentration',
        'ritual',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'level' => 'integer',
        'school' => SpellSchool::class,
        'components' => 'array',
        'concentration' => 'boolean',
        'ritual' => 'boolean',
    ];

    /**
     * Get the classes that have access to this spell.
     *
     * @return BelongsToMany<CharacterClass, Spell>
     */
    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(CharacterClass::class, 'class_spells')
            ->withTimestamps();
    }
}
