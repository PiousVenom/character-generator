<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

final class ClassFeature extends Model
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
        'subclass_id',
        'name',
        'description',
        'level_acquired',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'level_acquired' => 'integer',
    ];

    /**
     * Get the class that this feature belongs to.
     *
     * @return BelongsTo<CharacterClass, ClassFeature>
     */
    public function characterClass(): BelongsTo
    {
        return $this->belongsTo(CharacterClass::class, 'class_id');
    }

    /**
     * Get the subclass that this feature belongs to.
     *
     * @return BelongsTo<Subclass, ClassFeature>
     */
    public function subclass(): BelongsTo
    {
        return $this->belongsTo(Subclass::class, 'subclass_id');
    }
}
