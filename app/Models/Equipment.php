<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string                                                   $id
 * @property string                                                   $name
 * @property string                                                   $slug
 * @property string|null                                              $description
 * @property string                                                   $equipment_type
 * @property string|null                                              $equipment_subtype
 * @property int                                                      $cost_cp
 * @property string|null                                              $weight_lb
 * @property string|null                                              $damage_dice
 * @property string|null                                              $damage_type
 * @property array<string>|null                                       $properties
 * @property int|null                                                 $armor_class
 * @property int|null                                                 $armor_dex_cap
 * @property int|null                                                 $strength_requirement
 * @property bool                                                     $stealth_disadvantage
 * @property int|null                                                 $range_normal
 * @property int|null                                                 $range_long
 * @property \Illuminate\Support\Carbon|null                          $created_at
 * @property \Illuminate\Support\Carbon|null                          $updated_at
 * @property \Illuminate\Support\Carbon|null                          $deleted_at
 * @property \Illuminate\Database\Eloquent\Collection<int, Character> $characters
 */
final class Equipment extends Model
{
    /** @use HasFactory<\Database\Factories\EquipmentFactory> */
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    public $incrementing = false;

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'cost_cp'              => 0,
        'stealth_disadvantage' => false,
    ];

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'equipment_type',
        'equipment_subtype',
        'cost_cp',
        'weight_lb',
        'damage_dice',
        'damage_type',
        'properties',
        'armor_class',
        'armor_dex_cap',
        'strength_requirement',
        'stealth_disadvantage',
        'range_normal',
        'range_long',
    ];

    protected $keyType = 'string';

    protected $table = 'equipment';

    /**
     * @return BelongsToMany<Character, $this>
     */
    public function characters(): BelongsToMany
    {
        return $this->belongsToMany(Character::class, 'character_equipment')
            ->withPivot(['quantity', 'equipped', 'attuned', 'notes'])
            ->withTimestamps();
    }

    /**
     * @param Builder<Equipment> $query
     *
     * @return Builder<Equipment>
     */
    public function scopeArmor(Builder $query): Builder
    {
        return $query->where('equipment_type', 'armor');
    }

    /**
     * @param Builder<Equipment> $query
     *
     * @return Builder<Equipment>
     */
    public function scopeByType(Builder $query, string $type): Builder
    {
        return $query->where('equipment_type', $type);
    }

    /**
     * @param Builder<Equipment> $query
     *
     * @return Builder<Equipment>
     */
    public function scopeWeapons(Builder $query): Builder
    {
        return $query->where('equipment_type', 'weapon');
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'cost_cp'              => 'integer',
            'weight_lb'            => 'decimal:2',
            'properties'           => 'array',
            'armor_class'          => 'integer',
            'armor_dex_cap'        => 'integer',
            'strength_requirement' => 'integer',
            'stealth_disadvantage' => 'boolean',
            'range_normal'         => 'integer',
            'range_long'           => 'integer',
        ];
    }
}
