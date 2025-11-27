<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Subclass extends Model
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
        'class_id',
        'name',
        'description',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [];

    /**
     * Get the class that this subclass belongs to.
     *
     * @return BelongsTo<CharacterClass, Subclass>
     */
    public function characterClass(): BelongsTo
    {
        return $this->belongsTo(CharacterClass::class, 'class_id');
    }

    /**
     * Get the features for this subclass.
     *
     * @return HasMany<ClassFeature, Subclass>
     */
    public function features(): HasMany
    {
        return $this->hasMany(ClassFeature::class, 'subclass_id');
    }
}
