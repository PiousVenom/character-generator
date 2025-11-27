<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Severity;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class ErrorLog extends Model
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
        'correlation_id',
        'exception_class',
        'message',
        'code',
        'file',
        'line',
        'trace',
        'severity',
        'context',
        'occurred_at',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'line' => 'integer',
        'severity' => Severity::class,
        'context' => 'array',
        'occurred_at' => 'datetime',
    ];
}
