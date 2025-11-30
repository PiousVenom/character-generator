<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string                          $id
 * @property string                          $character_id
 * @property int                             $strength
 * @property int                             $dexterity
 * @property int                             $constitution
 * @property int                             $intelligence
 * @property int                             $wisdom
 * @property int                             $charisma
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property Character                       $character
 * @property int                             $strength_modifier
 * @property int                             $dexterity_modifier
 * @property int                             $constitution_modifier
 * @property int                             $intelligence_modifier
 * @property int                             $wisdom_modifier
 * @property int                             $charisma_modifier
 */
final class AbilityScore extends Model
{
    /** @use HasFactory<\Database\Factories\AbilityScoreFactory> */
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    public $incrementing = false;

    /**
     * @var list<string>
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

    protected $keyType = 'string';

    /**
     * @return BelongsTo<Character, $this>
     */
    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class, 'character_id');
    }

    /**
     * Get modifier for any ability by name.
     */
    public function getModifier(string $ability): int
    {
        $score = match ($ability) {
            'strength'     => $this->strength,
            'dexterity'    => $this->dexterity,
            'constitution' => $this->constitution,
            'intelligence' => $this->intelligence,
            'wisdom'       => $this->wisdom,
            'charisma'     => $this->charisma,
            default        => 10,
        };

        return (int) floor(($score - 10) / 2);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'strength'     => 'integer',
            'dexterity'    => 'integer',
            'constitution' => 'integer',
            'intelligence' => 'integer',
            'wisdom'       => 'integer',
            'charisma'     => 'integer',
        ];
    }

    /**
     * @return Attribute<int, never>
     */
    protected function charismaModifier(): Attribute
    {
        return Attribute::make(
            get: fn (): int => (int) floor(($this->charisma - 10) / 2),
        );
    }

    /**
     * @return Attribute<int, never>
     */
    protected function constitutionModifier(): Attribute
    {
        return Attribute::make(
            get: fn (): int => (int) floor(($this->constitution - 10) / 2),
        );
    }

    /**
     * @return Attribute<int, never>
     */
    protected function dexterityModifier(): Attribute
    {
        return Attribute::make(
            get: fn (): int => (int) floor(($this->dexterity - 10) / 2),
        );
    }

    /**
     * @return Attribute<int, never>
     */
    protected function intelligenceModifier(): Attribute
    {
        return Attribute::make(
            get: fn (): int => (int) floor(($this->intelligence - 10) / 2),
        );
    }

    /**
     * @return Attribute<int, never>
     */
    protected function strengthModifier(): Attribute
    {
        return Attribute::make(
            get: fn (): int => (int) floor(($this->strength - 10) / 2),
        );
    }

    /**
     * @return Attribute<int, never>
     */
    protected function wisdomModifier(): Attribute
    {
        return Attribute::make(
            get: fn (): int => (int) floor(($this->wisdom - 10) / 2),
        );
    }
}
