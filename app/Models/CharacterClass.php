<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class CharacterClass extends Model
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
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'classes';

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
        'hit_die',
        'primary_ability',
        'saving_throw_proficiencies',
        'armor_proficiencies',
        'weapon_proficiencies',
        'tool_proficiencies',
        'skill_choices_count',
        'skill_choices_list',
        'spellcasting_ability',
        'spell_slots_progression',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'saving_throw_proficiencies' => 'array',
        'armor_proficiencies' => 'array',
        'weapon_proficiencies' => 'array',
        'tool_proficiencies' => 'array',
        'skill_choices_list' => 'array',
        'spell_slots_progression' => 'array',
        'skill_choices_count' => 'integer',
    ];

    /**
     * Get the subclasses for this class.
     *
     * @return HasMany<Subclass, CharacterClass>
     */
    public function subclasses(): HasMany
    {
        return $this->hasMany(Subclass::class, 'class_id');
    }

    /**
     * Get the features for this class.
     *
     * @return HasMany<ClassFeature, CharacterClass>
     */
    public function features(): HasMany
    {
        return $this->hasMany(ClassFeature::class, 'class_id');
    }

    /**
     * Get the spells available to this class.
     *
     * @return BelongsToMany<Spell, CharacterClass>
     */
    public function spells(): BelongsToMany
    {
        return $this->belongsToMany(Spell::class, 'class_spells')
            ->withTimestamps();
    }
}
