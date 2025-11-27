<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

final class RequestLog extends Model
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
        'method',
        'url',
        'route_name',
        'ip_address',
        'user_agent',
        'request_headers',
        'request_body',
        'response_status',
        'response_body',
        'execution_time',
        'memory_usage',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'request_headers' => 'array',
        'request_body' => 'array',
        'response_status' => 'integer',
        'response_body' => 'array',
        'execution_time' => 'decimal:4',
        'memory_usage' => 'integer',
    ];
}
