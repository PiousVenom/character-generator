<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string                                                   $id
 * @property string                                                   $name
 * @property string                                                   $slug
 * @property string                                                   $description
 * @property string                                                   $ability
 * @property \Illuminate\Support\Carbon|null                          $created_at
 * @property \Illuminate\Support\Carbon|null                          $updated_at
 * @property \Illuminate\Support\Carbon|null                          $deleted_at
 * @property \Illuminate\Database\Eloquent\Collection<int, Character> $characters
 */
final class Skill extends Model
{
    /** @use HasFactory<\Database\Factories\SkillFactory> */
    use HasFactory;
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
        'ability',
    ];

    protected $keyType = 'string';

    /**
     * @return BelongsToMany<Character, $this>
     */
    public function characters(): BelongsToMany
    {
        return $this->belongsToMany(Character::class, 'character_skills')
            ->withPivot(['proficient', 'expertise'])
            ->withTimestamps();
    }
}
