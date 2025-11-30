<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string                                                   $id
 * @property string                                                   $name
 * @property string|null                                              $class_id
 * @property string|null                                              $species_id
 * @property string|null                                              $background_id
 * @property string|null                                              $subclass_id
 * @property int                                                      $level
 * @property int                                                      $experience_points
 * @property string|null                                              $alignment
 * @property int|null                                                 $max_hit_points
 * @property int|null                                                 $current_hit_points
 * @property int                                                      $temporary_hit_points
 * @property int|null                                                 $armor_class
 * @property int|null                                                 $initiative_bonus
 * @property int|null                                                 $speed
 * @property int                                                      $proficiency_bonus
 * @property bool                                                     $inspiration
 * @property array<string, mixed>|null                                $appearance
 * @property string|null                                              $personality_traits
 * @property string|null                                              $ideals
 * @property string|null                                              $bonds
 * @property string|null                                              $flaws
 * @property string|null                                              $backstory
 * @property string|null                                              $notes
 * @property \Illuminate\Support\Carbon|null                          $created_at
 * @property \Illuminate\Support\Carbon|null                          $updated_at
 * @property \Illuminate\Support\Carbon|null                          $deleted_at
 * @property CharacterClass|null                                      $class
 * @property Species|null                                             $species
 * @property Background|null                                          $background
 * @property Subclass|null                                            $subclass
 * @property AbilityScore|null                                        $abilityScores
 * @property \Illuminate\Database\Eloquent\Collection<int, Skill>     $skills
 * @property \Illuminate\Database\Eloquent\Collection<int, Equipment> $equipment
 * @property \Illuminate\Database\Eloquent\Collection<int, Spell>     $spells
 * @property \Illuminate\Database\Eloquent\Collection<int, Feat>      $feats
 */
final class Character extends Model
{
    /** @use HasFactory<\Database\Factories\CharacterFactory> */
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    public $incrementing = false;

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'level'                => 1,
        'experience_points'    => 0,
        'temporary_hit_points' => 0,
        'proficiency_bonus'    => 2,
        'inspiration'          => false,
    ];

    /**
     * @var list<string>
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
        'appearance',
        'personality_traits',
        'ideals',
        'bonds',
        'flaws',
        'backstory',
        'notes',
    ];

    protected $keyType = 'string';

    /**
     * @return HasOne<AbilityScore, $this>
     */
    public function abilityScores(): HasOne
    {
        return $this->hasOne(AbilityScore::class, 'character_id');
    }

    /**
     * @return BelongsTo<Background, $this>
     */
    public function background(): BelongsTo
    {
        return $this->belongsTo(Background::class, 'background_id');
    }

    /**
     * @return BelongsTo<CharacterClass, $this>
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(CharacterClass::class, 'class_id');
    }

    /**
     * @return BelongsToMany<Equipment, $this>
     */
    public function equipment(): BelongsToMany
    {
        return $this->belongsToMany(Equipment::class, 'character_equipment')
            ->withPivot(['quantity', 'equipped', 'attuned', 'notes'])
            ->withTimestamps();
    }

    /**
     * @return BelongsToMany<Feat, $this>
     */
    public function feats(): BelongsToMany
    {
        return $this->belongsToMany(Feat::class, 'character_feats')
            ->withPivot(['source', 'choices'])
            ->withTimestamps();
    }

    /**
     * @param Builder<Character> $query
     *
     * @return Builder<Character>
     */
    public function scopeByClass(Builder $query, string $classId): Builder
    {
        return $query->where('class_id', $classId);
    }

    /**
     * @param Builder<Character> $query
     *
     * @return Builder<Character>
     */
    public function scopeByLevel(Builder $query, int $min, ?int $max = null): Builder
    {
        $query->where('level', '>=', $min);

        if ($max !== null) {
            $query->where('level', '<=', $max);
        }

        return $query;
    }

    /**
     * @return BelongsToMany<Skill, $this>
     */
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'character_skills')
            ->withPivot(['proficient', 'expertise'])
            ->withTimestamps();
    }

    /**
     * @return BelongsTo<Species, $this>
     */
    public function species(): BelongsTo
    {
        return $this->belongsTo(Species::class, 'species_id');
    }

    /**
     * @return BelongsToMany<Spell, $this>
     */
    public function spells(): BelongsToMany
    {
        return $this->belongsToMany(Spell::class, 'character_spells')
            ->withPivot(['prepared', 'source'])
            ->withTimestamps();
    }

    /**
     * @return BelongsTo<Subclass, $this>
     */
    public function subclass(): BelongsTo
    {
        return $this->belongsTo(Subclass::class, 'subclass_id');
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'level'                => 'integer',
            'experience_points'    => 'integer',
            'max_hit_points'       => 'integer',
            'current_hit_points'   => 'integer',
            'temporary_hit_points' => 'integer',
            'armor_class'          => 'integer',
            'initiative_bonus'     => 'integer',
            'speed'                => 'integer',
            'proficiency_bonus'    => 'integer',
            'inspiration'          => 'boolean',
            'appearance'           => 'array',
        ];
    }
}
