<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string                          $id
 * @property string                          $correlation_id
 * @property string                          $method
 * @property string                          $url
 * @property string|null                     $route_name
 * @property string|null                     $ip_address
 * @property string|null                     $user_agent
 * @property array<string, mixed>|null       $request_headers
 * @property array<string, mixed>|null       $request_body
 * @property int|null                        $response_status
 * @property array<string, mixed>|null       $response_body
 * @property string|null                     $execution_time_ms
 * @property int|null                        $memory_usage_bytes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
final class RequestLog extends Model
{
    use HasUuids;

    public $incrementing = false;

    /**
     * @var list<string>
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
        'execution_time_ms',
        'memory_usage_bytes',
    ];

    protected $keyType = 'string';

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'request_headers'    => 'array',
            'request_body'       => 'array',
            'response_status'    => 'integer',
            'response_body'      => 'array',
            'execution_time_ms'  => 'decimal:4',
            'memory_usage_bytes' => 'integer',
        ];
    }
}
