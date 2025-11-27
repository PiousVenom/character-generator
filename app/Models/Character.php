<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Alignment;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Character extends Model
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
        'class_id',
        'species_id',
        'background_id',
        'subclass_id',
        'level',
        'experience_points',
        'alignment',
        'max_hit_points',
        'current_hit_points',
        'temporary_hit_points',
        'armor_class',
        'initiative_bonus',
        'speed',
        'proficiency_bonus',
        'inspiration',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'level' => 'integer',
        'experience_points' => 'integer',
        'alignment' => Alignment::class,
        'max_hit_points' => 'integer',
        'current_hit_points' => 'integer',
        'temporary_hit_points' => 'integer',
        'armor_class' => 'integer',
        'initiative_bonus' => 'integer',
        'speed' => 'integer',
        'proficiency_bonus' => 'integer',
        'inspiration' => 'boolean',
    ];

    /**
     * Get the class that this character belongs to.
     *
     * @return BelongsTo<CharacterClass, Character>
     */
    public function characterClass(): BelongsTo
    {
        return $this->belongsTo(CharacterClass::class, 'class_id');
    }

    /**
     * Get the species of this character.
     *
     * @return BelongsTo<Species, Character>
     */
    public function species(): BelongsTo
    {
        return $this->belongsTo(Species::class);
    }

    /**
     * Get the background of this character.
     *
     * @return BelongsTo<Background, Character>
     */
    public function background(): BelongsTo
    {
        return $this->belongsTo(Background::class);
    }

    /**
     * Get the subclass of this character.
     *
     * @return BelongsTo<Subclass, Character>
     */
    public function subclass(): BelongsTo
    {
        return $this->belongsTo(Subclass::class);
    }

    /**
     * Get the ability scores for this character.
     *
     * @return HasOne<AbilityScore, Character>
     */
    public function abilityScores(): HasOne
    {
        return $this->hasOne(AbilityScore::class);
    }

    /**
     * Get the character levels for multiclassing.
     *
     * @return HasMany<CharacterLevel, Character>
     */
    public function characterLevels(): HasMany
    {
        return $this->hasMany(CharacterLevel::class);
    }

    /**
     * Get the skills for this character.
     *
     * @return BelongsToMany<Skill, Character>
     */
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'character_skills')
            ->withPivot(['is_proficient', 'has_expertise'])
            ->withTimestamps();
    }

    /**
     * Get the equipment for this character.
     *
     * @return BelongsToMany<Equipment, Character>
     */
    public function equipment(): BelongsToMany
    {
        return $this->belongsToMany(Equipment::class, 'character_equipment')
            ->withPivot(['quantity', 'is_equipped', 'is_attuned'])
            ->withTimestamps();
    }

    /**
     * Get the spells for this character.
     *
     * @return BelongsToMany<Spell, Character>
     */
    public function spells(): BelongsToMany
    {
        return $this->belongsToMany(Spell::class, 'character_spells')
            ->withPivot(['is_prepared'])
            ->withTimestamps();
    }

    /**
     * Get the feats for this character.
     *
     * @return BelongsToMany<Feat, Character>
     */
    public function feats(): BelongsToMany
    {
        return $this->belongsToMany(Feat::class, 'character_feats')
            ->withTimestamps();
    }

    /**
     * Boot method to handle cascading deletes for soft deletes.
     */
    protected static function booted(): void
    {
        static::deleting(function (Character $character): void {
            $character->abilityScores()->delete();
            $character->characterLevels()->delete();
        });

        static::restoring(function (Character $character): void {
            $character->abilityScores()->withTrashed()->restore();
            $character->characterLevels()->withTrashed()->restore();
        });
    }
}
