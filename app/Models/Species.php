<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Size;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Species extends Model
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
        'size',
        'speed',
        'ability_score_increases',
        'languages',
        'traits',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'size' => Size::class,
        'speed' => 'integer',
        'ability_score_increases' => 'array',
        'languages' => 'array',
        'traits' => 'array',
    ];
}
