<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string                          $id
 * @property string                          $class_id
 * @property string|null                     $subclass_id
 * @property string                          $name
 * @property string                          $description
 * @property int                             $level
 * @property bool                            $is_subclass_feature
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property CharacterClass                  $class
 * @property Subclass|null                   $subclass
 */
final class ClassFeature extends Model
{
    /** @use HasFactory<\Database\Factories\ClassFeatureFactory> */
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    public $incrementing = false;

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'is_subclass_feature' => false,
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'class_id',
        'subclass_id',
        'name',
        'description',
        'level',
        'is_subclass_feature',
    ];

    protected $keyType = 'string';

    /**
     * @return BelongsTo<CharacterClass, $this>
     */
    public function class(): BelongsTo
    {
        return $this->belongsTo(CharacterClass::class, 'class_id');
    }

    /**
     * @param Builder<ClassFeature> $query
     *
     * @return Builder<ClassFeature>
     */
    public function scopeBaseClassOnly(Builder $query): Builder
    {
        return $query->where('is_subclass_feature', false);
    }

    /**
     * @param Builder<ClassFeature> $query
     *
     * @return Builder<ClassFeature>
     */
    public function scopeByLevel(Builder $query, int $level): Builder
    {
        return $query->where('level', '<=', $level);
    }

    /**
     * @param Builder<ClassFeature> $query
     *
     * @return Builder<ClassFeature>
     */
    public function scopeSubclassOnly(Builder $query): Builder
    {
        return $query->where('is_subclass_feature', true);
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
            'level'               => 'integer',
            'is_subclass_feature' => 'boolean',
        ];
    }
}
