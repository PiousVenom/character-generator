<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class AbilityScore extends Model
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
        'strength',
        'dexterity',
        'constitution',
        'intelligence',
        'wisdom',
        'charisma',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'strength' => 'integer',
        'dexterity' => 'integer',
        'constitution' => 'integer',
        'intelligence' => 'integer',
        'wisdom' => 'integer',
        'charisma' => 'integer',
    ];

    /**
     * Accessors to append to model array/JSON.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'strength_modifier',
        'dexterity_modifier',
        'constitution_modifier',
        'intelligence_modifier',
        'wisdom_modifier',
        'charisma_modifier',
    ];

    /**
     * Get the character that owns the ability scores.
     *
     * @return BelongsTo<Character, AbilityScore>
     */
    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }

    /**
     * Get the strength modifier.
     *
     * @return Attribute<int, never>
     */
    protected function strengthModifier(): Attribute
    {
        return Attribute::make(
            get: fn (): int => $this->calculateModifier($this->strength),
        );
    }

    /**
     * Get the dexterity modifier.
     *
     * @return Attribute<int, never>
     */
    protected function dexterityModifier(): Attribute
    {
        return Attribute::make(
            get: fn (): int => $this->calculateModifier($this->dexterity),
        );
    }

    /**
     * Get the constitution modifier.
     *
     * @return Attribute<int, never>
     */
    protected function constitutionModifier(): Attribute
    {
        return Attribute::make(
            get: fn (): int => $this->calculateModifier($this->constitution),
        );
    }

    /**
     * Get the intelligence modifier.
     *
     * @return Attribute<int, never>
     */
    protected function intelligenceModifier(): Attribute
    {
        return Attribute::make(
            get: fn (): int => $this->calculateModifier($this->intelligence),
        );
    }

    /**
     * Get the wisdom modifier.
     *
     * @return Attribute<int, never>
     */
    protected function wisdomModifier(): Attribute
    {
        return Attribute::make(
            get: fn (): int => $this->calculateModifier($this->wisdom),
        );
    }

    /**
     * Get the charisma modifier.
     *
     * @return Attribute<int, never>
     */
    protected function charismaModifier(): Attribute
    {
        return Attribute::make(
            get: fn (): int => $this->calculateModifier($this->charisma),
        );
    }

    /**
     * Calculate the modifier for an ability score.
     */
    private function calculateModifier(int $score): int
    {
        return (int) floor(($score - 10) / 2);
    }
}
