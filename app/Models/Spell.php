<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string                                                        $id
 * @property string                                                        $name
 * @property string                                                        $slug
 * @property string                                                        $description
 * @property int                                                           $level
 * @property string                                                        $school
 * @property string                                                        $casting_time
 * @property string                                                        $range
 * @property bool                                                          $components_verbal
 * @property bool                                                          $components_somatic
 * @property string|null                                                   $components_material
 * @property string|null                                                   $components_material_cost
 * @property bool                                                          $components_material_consumed
 * @property string                                                        $duration
 * @property bool                                                          $concentration
 * @property bool                                                          $ritual
 * @property string|null                                                   $higher_levels
 * @property \Illuminate\Support\Carbon|null                               $created_at
 * @property \Illuminate\Support\Carbon|null                               $updated_at
 * @property \Illuminate\Support\Carbon|null                               $deleted_at
 * @property \Illuminate\Database\Eloquent\Collection<int, Character>      $characters
 * @property \Illuminate\Database\Eloquent\Collection<int, CharacterClass> $classes
 * @property bool                                                          $is_cantrip
 */
final class Spell extends Model
{
    use HasUuids;
    use SoftDeletes;

    public $incrementing = false;

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'components_verbal'            => false,
        'components_somatic'           => false,
        'components_material_consumed' => false,
        'concentration'                => false,
        'ritual'                       => false,
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'level',
        'school',
        'casting_time',
        'range',
        'components_verbal',
        'components_somatic',
        'components_material',
        'components_material_cost',
        'components_material_consumed',
        'duration',
        'concentration',
        'ritual',
        'higher_levels',
    ];

    protected $keyType = 'string';

    /**
     * @return BelongsToMany<Character, $this>
     */
    public function characters(): BelongsToMany
    {
        return $this->belongsToMany(Character::class, 'character_spells')
            ->withPivot(['prepared', 'source'])
            ->withTimestamps();
    }

    /**
     * @return BelongsToMany<CharacterClass, $this>
     */
    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(CharacterClass::class, 'class_spells', 'spell_id', 'class_id')
            ->withPivot('level_available')
            ->withTimestamps();
    }

    /**
     * @param Builder<Spell> $query
     *
     * @return Builder<Spell>
     */
    public function scopeByLevel(Builder $query, int $level): Builder
    {
        return $query->where('level', $level);
    }

    /**
     * @param Builder<Spell> $query
     *
     * @return Builder<Spell>
     */
    public function scopeBySchool(Builder $query, string $school): Builder
    {
        return $query->where('school', $school);
    }

    /**
     * @param Builder<Spell> $query
     *
     * @return Builder<Spell>
     */
    public function scopeCantrips(Builder $query): Builder
    {
        return $query->where('level', 0);
    }

    /**
     * @param Builder<Spell> $query
     *
     * @return Builder<Spell>
     */
    public function scopeConcentration(Builder $query): Builder
    {
        return $query->where('concentration', true);
    }

    /**
     * @param Builder<Spell> $query
     *
     * @return Builder<Spell>
     */
    public function scopeRituals(Builder $query): Builder
    {
        return $query->where('ritual', true);
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'level'                        => 'integer',
            'components_verbal'            => 'boolean',
            'components_somatic'           => 'boolean',
            'components_material_cost'     => 'decimal:2',
            'components_material_consumed' => 'boolean',
            'concentration'                => 'boolean',
            'ritual'                       => 'boolean',
        ];
    }

    /**
     * @return Attribute<bool, never>
     */
    protected function isCantrip(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->level === 0,
        );
    }
}
