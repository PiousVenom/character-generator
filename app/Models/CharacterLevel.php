<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class CharacterLevel extends Model
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
        'character_id',
        'class_id',
        'level',
        'hit_points_gained',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'level' => 'integer',
        'hit_points_gained' => 'integer',
    ];

    /**
     * Get the character that owns this level.
     *
     * @return BelongsTo<Character, CharacterLevel>
     */
    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    /**
     * Get the class for this level.
     *
     * @return BelongsTo<CharacterClass, CharacterLevel>
     */
    public function characterClass(): BelongsTo
    {
        return $this->belongsTo(CharacterClass::class, 'class_id');
    }
}
