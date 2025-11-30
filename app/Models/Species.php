<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string                                                   $id
 * @property string                                                   $name
 * @property string                                                   $slug
 * @property string                                                   $description
 * @property string                                                   $size
 * @property int                                                      $speed
 * @property string                                                   $creature_type
 * @property int|null                                                 $darkvision
 * @property array<array{name: string, description: string}>          $traits
 * @property array<string>                                            $languages
 * @property array<mixed>|null                                        $ability_score_options
 * @property bool                                                     $has_lineage_choice
 * @property array<mixed>|null                                        $lineages
 * @property \Illuminate\Support\Carbon|null                          $created_at
 * @property \Illuminate\Support\Carbon|null                          $updated_at
 * @property \Illuminate\Support\Carbon|null                          $deleted_at
 * @property \Illuminate\Database\Eloquent\Collection<int, Character> $characters
 */
final class Species extends Model
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
        'size',
        'speed',
        'creature_type',
        'darkvision',
        'traits',
        'languages',
        'ability_score_options',
        'has_lineage_choice',
        'lineages',
    ];

    protected $keyType = 'string';

    protected $table = 'species';

    /**
     * @return HasMany<Character, $this>
     */
    public function characters(): HasMany
    {
        return $this->hasMany(Character::class, 'species_id');
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'speed'                 => 'integer',
            'darkvision'            => 'integer',
            'traits'                => 'array',
            'languages'             => 'array',
            'ability_score_options' => 'array',
            'has_lineage_choice'    => 'boolean',
            'lineages'              => 'array',
        ];
    }
}
