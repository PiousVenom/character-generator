<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Background extends Model
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
        'name',
        'description',
        'skill_proficiencies',
        'tool_proficiencies',
        'languages',
        'starting_equipment',
        'feature_name',
        'feature_description',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'skill_proficiencies' => 'array',
        'tool_proficiencies' => 'array',
        'languages' => 'array',
        'starting_equipment' => 'array',
    ];
}
