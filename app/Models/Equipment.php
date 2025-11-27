<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\EquipmentType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class Equipment extends Model
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
        'type',
        'description',
        'cost_copper',
        'weight',
        'properties',
        'weapon_properties',
        'armor_properties',
        'requires_attunement',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'type' => EquipmentType::class,
        'cost_copper' => 'integer',
        'weight' => 'decimal:2',
        'properties' => 'array',
        'weapon_properties' => 'array',
        'armor_properties' => 'array',
        'requires_attunement' => 'boolean',
    ];
}
