<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string                                                      $id
 * @property string                                                      $name
 * @property string                                                      $slug
 * @property string                                                      $description
 * @property int                                                         $hit_die
 * @property array<string>                                               $primary_abilities
 * @property array<string>                                               $saving_throw_proficiencies
 * @property array<string>                                               $armor_proficiencies
 * @property array<string>                                               $weapon_proficiencies
 * @property array<string>|null                                          $tool_proficiencies
 * @property array{count: int, options: array<string>}                   $skill_choices
 * @property array<mixed>                                                $starting_equipment
 * @property string|null                                                 $spellcasting_ability
 * @property int                                                         $subclass_level
 * @property \Illuminate\Support\Carbon|null                             $created_at
 * @property \Illuminate\Support\Carbon|null                             $updated_at
 * @property \Illuminate\Support\Carbon|null                             $deleted_at
 * @property \Illuminate\Database\Eloquent\Collection<int, Character>    $characters
 * @property \Illuminate\Database\Eloquent\Collection<int, Subclass>     $subclasses
 * @property \Illuminate\Database\Eloquent\Collection<int, ClassFeature> $features
 * @property \Illuminate\Database\Eloquent\Collection<int, Spell>        $spells
 */
final class CharacterClass extends Model
{
    use HasUuids;
    use SoftDeletes;

    public $incrementing = false;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'hit_die',
        'primary_abilities',
        'saving_throw_proficiencies',
        'armor_proficiencies',
        'weapon_proficiencies',
        'tool_proficiencies',
        'skill_choices',
        'starting_equipment',
        'spellcasting_ability',
        'subclass_level',
    ];

    protected $keyType = 'string';

    protected $table = 'classes';

    /**
     * @return HasMany<Character, $this>
     */
    public function characters(): HasMany
    {
        return $this->hasMany(Character::class, 'class_id');
    }

    /**
     * @return HasMany<ClassFeature, $this>
     */
    public function features(): HasMany
    {
        return $this->hasMany(ClassFeature::class, 'class_id');
    }

    /**
     * @return BelongsToMany<Spell, $this>
     */
    public function spells(): BelongsToMany
    {
        return $this->belongsToMany(Spell::class, 'class_spells', 'class_id', 'spell_id')
            ->withPivot('level_available')
            ->withTimestamps();
    }

    /**
     * @return HasMany<Subclass, $this>
     */
    public function subclasses(): HasMany
    {
        return $this->hasMany(Subclass::class, 'class_id');
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'hit_die'                    => 'integer',
            'primary_abilities'          => 'array',
            'saving_throw_proficiencies' => 'array',
            'armor_proficiencies'        => 'array',
            'weapon_proficiencies'       => 'array',
            'tool_proficiencies'         => 'array',
            'skill_choices'              => 'array',
            'starting_equipment'         => 'array',
            'subclass_level'             => 'integer',
        ];
    }
}
