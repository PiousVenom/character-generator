<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string                                                      $id
 * @property string                                                      $class_id
 * @property string                                                      $name
 * @property string                                                      $slug
 * @property string                                                      $description
 * @property string                                                      $source
 * @property \Illuminate\Support\Carbon|null                             $created_at
 * @property \Illuminate\Support\Carbon|null                             $updated_at
 * @property \Illuminate\Support\Carbon|null                             $deleted_at
 * @property CharacterClass                                              $class
 * @property \Illuminate\Database\Eloquent\Collection<int, ClassFeature> $features
 * @property \Illuminate\Database\Eloquent\Collection<int, Character>    $characters
 */
final class Subclass extends Model
{
    use HasUuids;
    use SoftDeletes;

    public $incrementing = false;

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'source' => 'PHB 2024',
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'class_id',
        'name',
        'slug',
        'description',
        'source',
    ];

    protected $keyType = 'string';

    /**
     * @return HasMany<Character, $this>
     */
    public function characters(): HasMany
    {
        return $this->hasMany(Character::class, 'subclass_id');
    }

    /**
     * @return BelongsTo<CharacterClass, $this>
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(CharacterClass::class, 'class_id');
    }

    /**
     * @return HasMany<ClassFeature, $this>
     */
    public function features(): HasMany
    {
        return $this->hasMany(ClassFeature::class, 'subclass_id');
    }
}
