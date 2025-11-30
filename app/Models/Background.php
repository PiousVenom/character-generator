<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string                                                   $id
 * @property string                                                   $name
 * @property string                                                   $slug
 * @property string                                                   $description
 * @property array<string>                                            $skill_proficiencies
 * @property string                                                   $tool_proficiency
 * @property array<string>|null                                       $tool_proficiency_choices
 * @property array<mixed>                                             $starting_equipment
 * @property string                                                   $starting_gold
 * @property string|null                                              $origin_feat_id
 * @property string|null                                              $feature_name
 * @property string|null                                              $feature_description
 * @property \Illuminate\Support\Carbon|null                          $created_at
 * @property \Illuminate\Support\Carbon|null                          $updated_at
 * @property \Illuminate\Support\Carbon|null                          $deleted_at
 * @property \Illuminate\Database\Eloquent\Collection<int, Character> $characters
 * @property Feat|null                                                $originFeat
 */
final class Background extends Model
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
        'skill_proficiencies',
        'tool_proficiency',
        'tool_proficiency_choices',
        'starting_equipment',
        'starting_gold',
        'origin_feat_id',
        'feature_name',
        'feature_description',
    ];

    protected $keyType = 'string';

    /**
     * @return HasMany<Character, $this>
     */
    public function characters(): HasMany
    {
        return $this->hasMany(Character::class, 'background_id');
    }

    /**
     * @return BelongsTo<Feat, $this>
     */
    public function originFeat(): BelongsTo
    {
        return $this->belongsTo(Feat::class, 'origin_feat_id');
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'skill_proficiencies'      => 'array',
            'tool_proficiency_choices' => 'array',
            'starting_equipment'       => 'array',
            'starting_gold'            => 'decimal:2',
        ];
    }
}
