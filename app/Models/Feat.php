<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string                                                    $id
 * @property string                                                    $name
 * @property string                                                    $slug
 * @property string                                                    $description
 * @property string                                                    $category
 * @property int|null                                                  $level_requirement
 * @property array<mixed>|null                                         $prerequisites
 * @property array<string>                                             $benefits
 * @property array{ability: string, amount: int}|null                  $ability_score_increase
 * @property bool                                                      $repeatable
 * @property \Illuminate\Support\Carbon|null                           $created_at
 * @property \Illuminate\Support\Carbon|null                           $updated_at
 * @property \Illuminate\Support\Carbon|null                           $deleted_at
 * @property \Illuminate\Database\Eloquent\Collection<int, Character>  $characters
 * @property \Illuminate\Database\Eloquent\Collection<int, Background> $backgrounds
 * @property bool                                                      $is_origin_feat
 */
final class Feat extends Model
{
    /** @use HasFactory<\Database\Factories\FeatFactory> */
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    public $incrementing = false;

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'repeatable' => false,
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'category',
        'level_requirement',
        'prerequisites',
        'benefits',
        'ability_score_increase',
        'repeatable',
    ];

    protected $keyType = 'string';

    /**
     * @return HasMany<Background, $this>
     */
    public function backgrounds(): HasMany
    {
        return $this->hasMany(Background::class, 'origin_feat_id');
    }

    /**
     * @return BelongsToMany<Character, $this>
     */
    public function characters(): BelongsToMany
    {
        return $this->belongsToMany(Character::class, 'character_feats')
            ->withPivot(['source', 'choices'])
            ->withTimestamps();
    }

    /**
     * @param Builder<Feat> $query
     *
     * @return Builder<Feat>
     */
    public function scopeByCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    /**
     * @param Builder<Feat> $query
     *
     * @return Builder<Feat>
     */
    public function scopeGeneralFeats(Builder $query): Builder
    {
        return $query->where('category', 'general');
    }

    /**
     * @param Builder<Feat> $query
     *
     * @return Builder<Feat>
     */
    public function scopeOriginFeats(Builder $query): Builder
    {
        return $query->where('category', 'origin');
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'level_requirement'      => 'integer',
            'prerequisites'          => 'array',
            'benefits'               => 'array',
            'ability_score_increase' => 'array',
            'repeatable'             => 'boolean',
        ];
    }

    /**
     * @return Attribute<bool, never>
     */
    protected function isOriginFeat(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->category === 'origin',
        );
    }
}
